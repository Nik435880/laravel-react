<?php

namespace App\Actions;

use App\Events\RoomCreated;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class CreateRoom
{
    public function __construct(
        private AddUser $addUser,
    ) {}

    /**
     * @param  array<Room>  $attributes
     */
    public function execute(array $attributes): Room
    {
        // Find the user by name
        $user = User::where('name', $attributes['name'])->first();

        if (! $user) {
            throw new \Exception("User with name '{$attributes['name']}' not found.");
        }

        // Check if a room already exists between the current user and the target user
        $existingRoom = Room::whereHas('users', function ($query) use ($user): void {
            $query->where('user_id', $user->id);
        })->whereHas('users', function ($query): void {
            $query->where('user_id', Auth::id());
        })->first();

        if ($existingRoom) {
            return $existingRoom;
        }

        $room = DB::transaction(function () use ($attributes, $user) {

            $room = Room::create($attributes);

            $this->addUser->execute(Auth::user(), $room);

            $this->addUser->execute($user, $room);

            return $room;

        });

        broadcast(new RoomCreated($room))->toOthers();

        return $room;

    }
}
