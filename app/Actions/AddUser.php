<?php

namespace App\Actions;
use App\Models\User;
use App\Models\Room;

class AddUser
{
    public function execute(User $user, Room $room)
    {
        $room->users()->attach($user);

    }

}
