<?php

namespace App\Http\Controllers;

use App\Events\RoomCreated;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoomController extends Controller
{

    public function store(RoomRequest $request, Room $room)
    {
        if (!$request->user()->can("create", $room)) {
            abort(403, "Unauthorized action.");
        }

        $user = User::where('name', '=', $request->name)->first();

        if ($request->name === Auth::user()->name) {
            return back()->withErrors(['message' => 'You cannot create a room with yourself.']);
        }


        if (!$user) {
            return back()->withErrors(['message' => 'User not found.']);
        }

        $room = $room->create([
            'name' => $request->name,
        ]);

        // Attach the authenticated user to the room
        $room->users()->syncWithoutDetaching(Auth::id());

        $room->users()->syncWithoutDetaching($user->id);

        // Create a message in the room
        if ($request->text !== null) {
            $room->messages()->create([
                'text' => $request->text,
                'room_id' => $room->id,
                'user_id' => Auth::id(),
            ]);
        }

        broadcast(new RoomCreated($room));
   
    }

    public function show(Request $request, Room $room)
    {

        if (!$request->user()->can('view', $room)) {
            abort(403, 'Unauthorized action.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('avatar');


        return Inertia::render('rooms/show', [
            'room' => $room->load([
                'users',
                'messages',
                'messages.user.avatar',
                'messages.images'
            ]),
            // ...existing code...
        ]);
    }
}
