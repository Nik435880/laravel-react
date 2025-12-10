<?php

use App\Models\Room;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {

    $room = Room::factory()->create();
    $this->get('/rooms/'.$room->id)->assertRedirect('/login');
});

test('users can create a room', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();

    $this->actingAs($user)->post(
        '/rooms',
        [
            'name' => $room->name,
        ]
    )->assertStatus(200);

    $this->assertDatabaseHas('rooms', [
        'name' => $room->name,
    ]);

});

test('users can view a room', function () {
    $user = User::factory()->create();
    $room = Room::factory()->create();

    $user->rooms()->attach($room->id);

    $this->actingAs($user)->get('/rooms/'.$room->id)->assertOk();
});
