<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Inertia\Inertia;
use App\Actions\CreateRoom;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class RoomController extends Controller
{
    /**
     * Create a new room with the given name
     *
     * @param \App\Http\Requests\RoomRequest $request
     * @param \App\Actions\CreateRoom $createRoom
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoomRequest $request, CreateRoom $createRoom): RedirectResponse
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
            'messages.images',
            'messages.user.avatar'
        ]);

        return Inertia::render('rooms/show', [
            'room' => $room,
            'user' => $user,
        ]);
    }


}
