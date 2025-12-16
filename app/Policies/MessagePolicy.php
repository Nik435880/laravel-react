<?php

namespace App\Policies;

use App\Models\User;

class MessagePolicy
{
    public function create(User $user, Message $message): bool
    {
        return $message->room->users->contains($user);

    }
}
