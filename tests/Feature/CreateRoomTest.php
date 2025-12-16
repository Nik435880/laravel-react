<?php

use App\Events\RoomCreated;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Event;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('creating a room returns existing two-user room', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $room = Room::factory()->create(['name' => $userB->name]);
    $room->users()->attach([$userA->id, $userB->id]);

    $this->actingAs($userA)
        ->post('/rooms', ['name' => $userB->name])
        ->assertStatus(200)
        ->assertJsonPath('room.id', $room->id);

    $this->assertEquals(1, Room::count());
});

test('users can create a new two-user room when none exists', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $response = $this->actingAs($userA)
        ->post('/rooms', ['name' => $userB->name]);

    $response->assertStatus(200);

    $this->assertDatabaseCount('rooms', 1);

    $room = Room::first();

    $this->assertDatabaseHas('room_user', ['room_id' => $room->id, 'user_id' => $userA->id]);
    $this->assertDatabaseHas('room_user', ['room_id' => $room->id, 'user_id' => $userB->id]);
});

test('room creation broadcasts RoomCreated event', function () {
    Event::fake();

    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $this->actingAs($userA)
        ->post('/rooms', ['name' => $userB->name]);

    Event::assertDispatched(RoomCreated::class);
});

test('name validation fails when too short', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $this->actingAs($userA)
        ->post('/rooms', ['name' => 'ab'])
        ->assertSessionHasErrors('name');
});

test('non-member cannot view a room (403)', function () {
    $member = User::factory()->create();
    $nonMember = User::factory()->create();

    $room = Room::factory()->create();
    $room->users()->attach($member->id);

    $this->actingAs($nonMember)
        ->get('/rooms/'.$room->id)
        ->assertStatus(403);
});

test('creating a room attaches exactly two unique users', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $this->actingAs($userA)
        ->post('/rooms', ['name' => $userB->name])
        ->assertStatus(200);

    $room = Room::first();

    $this->assertDatabaseCount('room_user', 2);

    $this->assertDatabaseHas('room_user', ['room_id' => $room->id, 'user_id' => $userA->id]);
    $this->assertDatabaseHas('room_user', ['room_id' => $room->id, 'user_id' => $userB->id]);
});
