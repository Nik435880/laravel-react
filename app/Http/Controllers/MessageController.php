<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Actions\CreateMessage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;


class MessageController extends Controller
{
    public function store(MessageRequest $request, CreateMessage $createMessage, Room $room)
    {

        $text = $request->input('text');
        $images = $request->file('images', []);

        $attributes = [
            'text' => $text,
            'images' => $images,
            'user_id' => Auth::id()
        ];

        $createMessage->execute($room, $attributes);

        return to_route('rooms.show', $room);

    }
}
