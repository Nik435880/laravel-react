<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\RoomUpdated;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(MessageRequest $request, Room $room)
    {

        if ($request->text === null && $request->file('images') === null) {
            return back()->withErrors(['message' => 'Message text or image is required.']);
        }

        $message = Message::create([
            'text' => $request->text,
            'user_id' => Auth::id(),
            'room_id' => $room->id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $message->images()->create(['image_path' => $path]);
            }
        }

        $room = $message->room;

        if (Auth::user()->id != $room->user_id) {

            broadcast(new MessageSent($message, $room));
            broadcast(new RoomUpdated($room));
        }

    }
}
