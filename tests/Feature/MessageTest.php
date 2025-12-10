<?php

use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can send message', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();
    $message = Message::factory()->create();

    $user->rooms()->attach($room);

    $this->actingAs($user)->post(
        '/rooms/'.$room->id,
        [
            'text' => $message->text,

        ]
    )->assertStatus(200);

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

    $response = $this->actingAs($user)->post('/rooms/'.$room->id, [
        'images' => [$file],
    ]);

    $response->assertStatus(200);

    Storage::disk('images')->assertExists($file->hashName());

    $this->assertDatabaseHas('images', [
        'image_path' => $image->image_path,
    ]);

});
