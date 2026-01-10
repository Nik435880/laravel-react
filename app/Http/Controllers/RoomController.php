<?php

namespace App\Http\Controllers;

use App\Actions\CreateRoom;
use App\Models\Room;
use App\Models\User;
use App\Http\Requests\RoomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function store(RoomRequest $request, CreateRoom $createRoom)
    {

        $attributes = [
            'name' => $request->name,
        ];

        $room = $createRoom->execute($attributes);

        return to_route('rooms.show', $room);

    }

    public function show(Request $request, Room $room)
    {

        if (!$request->user()->can('view', $room)) {
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
