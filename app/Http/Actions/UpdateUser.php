<?php

namespace App\Http\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UpdateUser
{
    public function execute(User $user, array $data): User
    {

        if ($data['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        /* if ($user->isDirty('email')) {
         $user->email_verified_at = null;
        } */

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => $user->email_verified_at,
        ]);

        if (isset($data['avatar'])) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar->avatar_path);
            }

            $path = $data['avatar']->store('avatars', 'public') ?? null;

            $user->avatar()->updateOrCreate([
                'avatar_path' => $path,
            ]);
        }

        return $user;

    }
}
