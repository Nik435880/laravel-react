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

    Storage::fake('images');

    if (! function_exists('imagejpeg')) {
        throw new LogicException('imagejpeg function is not defined and image cannot be generated.');
    }

    $file = UploadedFile::fake()->image('test.jpg');

    $response = $this->actingAs($user)->post('/rooms/'.$room->id, [
        'images' => [$file],
    ]);

    $response->assertStatus(200);

    Storage::disk('images')->assertExists($file->hashName());

    $this->assertDatabaseHas('images', [
        'image_path' => $file->hashName(),
    ]);

});
