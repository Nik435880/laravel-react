<?php

namespace App\Http\Controllers;

use App\Http\Actions\CreateMessage;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(MessageRequest $request, CreateMessage $createMessage)
    {

        /** @var int $user_id */
        /** @var string $text */
        /** @var array $images */
        /** @var int $room_id */
        /** @var \App\Models\Room $room */
        /** @var \App\Models\User $authUser */
        /** @var \App\Models\User $user */
        /** @var array $data */
        /** @var \App\Models\Message $message */
        $user_id = Auth::id();
        $roomParam = $request->route('room');
        $room_id = is_object($roomParam) ? $roomParam->id : (int) $roomParam;
        $room = Auth::user()->rooms()->find($room_id);
        if (! $room) {
            abort(404);
        }
        $room_id = $room->id;
        $text = $request->input('text');
        $images = $request->file('images', []);

        $data = [
            'user_id' => $user_id,
            'room_id' => $room_id,
            'text' => $text,
            'images' => $images,
        ];

        $message = $createMessage->execute($data);

    }
}
