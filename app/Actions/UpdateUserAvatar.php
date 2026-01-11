<?php

namespace App\Actions;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class UpdateUserAvatar
{
    public function execute(User $user, array $attributes)
    {
        if (isset($attributes['avatar'])) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar->avatar_path);
            }

            $path = $attributes['avatar']->store('avatars', 'public') ?? null;

            $user->avatar()->update([
                'avatar_path' => $path,
            ]);
        }

    }

}
