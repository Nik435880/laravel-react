<?php

namespace App\Actions;

use App\Models\Room;
use App\Models\User;

class AddUser
{
    public function execute(User $user, Room $room): void
    {
        $room->users()->attach($user);

    }
}
