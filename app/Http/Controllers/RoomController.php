<?php

namespace App\Http\Controllers;

use App\Actions\AddUser;
use App\Actions\CreateMessage;
use App\Actions\CreateRoom;
use App\Actions\UpdateRoom;
use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    public function store(CreateRoomRequest $request, CreateRoom $createRoom, AddUser $addUser): RedirectResponse
    {

        $room = $createRoom->execute($request->validated());

        $addUser->execute(Auth::user(), $room);

        return to_route('rooms.show', $room->id);
    }

    public function create(): Response
    {
        return Inertia::render('rooms/create');
    }

    public function show(Room $room): Response
    {

        /** @var User $user */
        $user = Auth::user();
        $user->load('avatar');

        $room->load([
            'users.avatar',
            'messages',
            'messages.images',
            'messages.user.avatar',
        ]);

        return Inertia::render('rooms/show', [
            'room' => $room,
            'user' => $user,
        ]);
    }

    public function update(UpdateRoomRequest $request, Room $room,  UpdateRoom $updateRoom): RedirectResponse
    {
        $updateRoom->execute($request->validated());

        return to_route('rooms.show', $room->id, 303);
    }
}
