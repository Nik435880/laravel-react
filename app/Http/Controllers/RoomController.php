<?php

namespace App\Http\Controllers;

use App\Http\Actions\CreateRoom;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function store(RoomRequest $request, CreateRoom $createRoom)
    {

        /** @var \App\Models\User $user */
        /** @var \App\Models\User $authUser */
        /** @var string $name */
        /** @var array $data */
        $user = User::where('name', '=', $request->name)->first();

        $authUser = Auth::user();
        $name = $request->name;
        $data = [
            'authUser' => $authUser,
            'user' => $user,
            'name' => $name,
        ];

        $room = $createRoom->execute($data);

        return response()->json(['room' => $room], 200);

    }

    public function show(Request $request, Room $room)
    {

        if (! $request->user()->can('view', $room)) {
            abort(403, 'Unauthorized action.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('avatar');

        $room->load([
            'users',
            'messages',
            'messages.user.avatar',
            'messages.images',
        ]);

        return Inertia::render('rooms/show', [
            'room' => $room,
            'user' => $user,
        ]);
    }
}
