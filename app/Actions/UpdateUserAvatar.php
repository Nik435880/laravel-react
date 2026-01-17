<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UpdateUserAvatar
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function execute(User $user, array $attributes): void
    {
        if (isset($attributes['avatar'])) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $attributes['avatar']->store('avatars', 'public') ?? null;

            $user->avatar()->update([
                'avatar_path' => $path,
            ]);
        }

    }
}
