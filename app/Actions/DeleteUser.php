<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteUser
{
    public function execute(User $user): void
    {
        Auth::logout();

        $user->delete();
    }
}
