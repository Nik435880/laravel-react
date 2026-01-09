<?php

namespace App\Http\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteUser
{
    public function execute(User $user)
    {
        Auth::logout();

        $user->delete();
    }
}
