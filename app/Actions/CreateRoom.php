<?php

namespace App\Actions;

use App\Models\Room;
use App\Models\User;
use App\Actions\AddUser;
use App\Events\RoomCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

final class CreateRoom
{

    public function __construct(
        private AddUser $addUser,
    ) {

    }

    public function execute(array $attributes): Room
    {

        $user = User::where('name', '=', $attributes['name'])->first();

        $existingRoom = Room::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', '=', $user->id);
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
