<?php

namespace App\Actions;

use App\Models\User;
use App\Actions\UpdateUserAvatar;

class UpdateUser
{
    public function __construct(
        private UpdateUserAvatar $updateUserAvatar,
    ) {

    }

    public function execute(User $user, array $attributes): User
    {

        if ($attributes['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        /* if ($user->isDirty('email')) {
         $user->email_verified_at = null;
        } */

        $user->update([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'email_verified_at' => $user->email_verified_at,
        ]);

        $this->updateUserAvatar->execute($user, $attributes);


        return $user;

    }
}
