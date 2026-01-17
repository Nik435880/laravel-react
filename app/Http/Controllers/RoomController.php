<?php

namespace App\Http\Controllers;

use App\Actions\CreateRoom;
use App\Actions\UpdateRoomMessages;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    use AuthorizesRequests;

    /**
     * Create a new room with the given name
     */
    public function store(RoomRequest $request, CreateRoom $createRoom): RedirectResponse
    {
        $room = $createRoom->execute($request->validated());

        return to_route('rooms.show', $room->id);

    }

    public function show(Request $request, Room $room): Response
    {
        $this->authorize('view', $room);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('avatar');

        $room->load([
            'users',
            'messages',
            'messages.images',
            'messages.user.avatar',
        ]);

        return Inertia::render('rooms/show', [
            'room' => $room,
            'user' => $user,
        ]);
    }

    public function update(MessageRequest $request, Room $room, UpdateRoomMessages $updateRoomMessages): RedirectResponse
    {
        $this->authorize('update', $room);

        $updateRoomMessages->execute($request->validated(), $room, $request->user());

        return to_route('rooms.show', $room->id, 303);
    }
}
