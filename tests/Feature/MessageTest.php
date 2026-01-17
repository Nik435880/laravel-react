<?php

use App\Events\MessageSent;
use App\Events\RoomUpdated;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can send message', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();
    $message = Message::factory()->create();

    $user->rooms()->attach($room);

    $this->actingAs($user)->put(
        '/rooms/'.$room->id,
        [
            'text' => $message->text,

        ]
    )->assertStatus(303);

    $this->assertDatabaseHas('messages', [
        'text' => $message->text,
    ]);
});

test('user can upload images', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();
    $message = Message::factory()->create();

    $user->rooms()->attach($room);
    $file = UploadedFile::fake()->image('test.jpg')->size(1024);

    Storage::fake('images')->put($file->hashName(), file_get_contents($file));

    $image = $message->images()->create([
        'image_path' => 'images/'.$file->hashName(),
    ]);

    $response = $this->actingAs($user)->put('/rooms/'.$room->id, [
        'images' => [$file],
    ]);

    $response->assertStatus(303);

    Storage::disk('images')->assertExists($file->hashName());

    $this->assertDatabaseHas('images', [
        'image_path' => $image->image_path,
    ]);

});

test('sending a message dispatches MessageSent and RoomUpdated events', function () {
    Event::fake();

    $user = User::factory()->create();
    $room = Room::factory()->create();

    $user->rooms()->attach($room);

    $this->actingAs($user)->put('/rooms/'.$room->id, [
        'text' => 'Hello world',
    ])->assertStatus(303);

    Event::assertDispatched(MessageSent::class);
    Event::assertDispatched(RoomUpdated::class);
});

test('validation fails for non-image upload', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();

    $user->rooms()->attach($room);

    $file = UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf');

    $this->actingAs($user)
        ->put('/rooms/'.$room->id, ['images' => [$file]])
        ->assertSessionHasErrors('images.0');
});

test('user can upload multiple images', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();

    $user->rooms()->attach($room);

    $file1 = UploadedFile::fake()->image('one.jpg')->size(500);
    $file2 = UploadedFile::fake()->image('two.jpg')->size(700);

    $response = $this->actingAs($user)
        ->put('/rooms/'.$room->id, ['images' => [$file1, $file2]]);

    $response->assertStatus(303);

    $message = \App\Models\Message::first();

    $this->assertNotNull($message);
    $this->assertEquals(2, $message->images()->count());
});

test('oversized image is rejected', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();

    $user->rooms()->attach($room);

    $big = UploadedFile::fake()->image('big.jpg')->size(3000); // 3MB

    $this->actingAs($user)
        ->put('/rooms/'.$room->id, ['images' => [$big]])
        ->assertSessionHasErrors('images.0');
});

test('sending images without text still creates a message with images', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();

    $user->rooms()->attach($room);

    $file = UploadedFile::fake()->image('pic.jpg')->size(400);

    $this->actingAs($user)
        ->put('/rooms/'.$room->id, ['images' => [$file]])
        ->assertStatus(303);

    $message = \App\Models\Message::first();

    $this->assertNotNull($message);
    $this->assertGreaterThanOrEqual(1, $message->images()->count());
});
