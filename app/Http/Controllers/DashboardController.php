<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {

        $users = User::where('id', '!=', auth()->id())->with('avatar')->get();

        $user = auth()->user();
        $user->load('avatar');

        return inertia('dashboard', [
            'user' => $user,
            'users' => $users,
        ]);
    }
}
