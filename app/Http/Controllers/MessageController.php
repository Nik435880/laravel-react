<?php

namespace App\Http\Controllers;

use App\Http\Actions\CreateMessage;
use App\Http\Requests\MessageRequest;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(MessageRequest $request, Room $room, CreateMessage $createMessage)
    {

        $user_id = Auth::id();
        $text = $request->input('text');
        $images = $request->file('images', []);

        $data = [
            'room_id' => $room->id,
            'user_id' => $user_id,
            'text' => $text,
            'images' => $images,
        ];

        $message = $createMessage->execute($data);

    }
}
