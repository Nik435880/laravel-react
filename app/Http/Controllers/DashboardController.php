<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): Response
    {

        $users = User::where('id', '!=', Auth::id())->with('avatar')->get();

        $user = Auth::user();
        $user->load('avatar');

        return inertia('dashboard', [
            'user' => $user,
            'users' => $users,
        ]);
    }
}
