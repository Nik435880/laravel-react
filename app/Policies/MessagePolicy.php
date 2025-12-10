<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Room;

class MessagePolicy
{

    public function create(User $user, Room $room): bool
    {
        return $room->users()->where('user_id', $user->id)->exists();
    }
}
