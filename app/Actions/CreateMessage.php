<?php

namespace App\Actions;

use App\Models\Room;
use App\Models\User;
use App\Actions\SendImages;
use App\Events\MessageSent;
use App\Events\RoomUpdated;

class CreateMessage
{
    public function __construct(
        private SendImages $sendImages
    ){

    }
    public function execute(Room $room, User $user, array $attributes)
    {


        $message = $room->messages()->create([
            'text' => $attributes['text'],
            'room_id' => $room->id,
            'user_id' => $user->id,
        ]);

        $this->sendImages->execute($message, $attributes);
        
        MessageSent::dispatch($message);
        RoomUpdated::dispatch($room);

        return $message;

    }
}
