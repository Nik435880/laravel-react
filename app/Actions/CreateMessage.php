<?php

namespace App\Actions;

use App\Events\MessageSent;
use App\Events\RoomUpdated;
use App\Models\Room;
use App\Models\Message;
use App\Actions\SendImages;
use Illuminate\Support\Facades\DB;

final class CreateMessage
{
    public function __construct(
        private SendImages $sendImages,
    ) {

    }

    public function execute(Room $room, array $attributes): ?Message
    {

        if (empty($attributes['text']) && empty($attributes['images'])) {
            return null;
        }

        $message = DB::transaction(function () use ($room, $attributes) {
            $message = $room->messages()->create($attributes);

            $this->sendImages->execute($message, $attributes);

            return $message;
        });

        broadcast(new MessageSent($message))->toOthers();
        broadcast(new RoomUpdated($message->room))->toOthers();

        return $message;



    }
}
