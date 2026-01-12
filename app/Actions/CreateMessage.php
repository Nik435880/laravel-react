<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Room;
use App\Models\Message;
use App\Actions\SendImages;
use App\Events\MessageSent;
use App\Events\RoomUpdated;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


final class CreateMessage
{
    public function __construct(
        private SendImages $sendImages,
    ) {

    }

    public function execute(User $user, Room $room, array $attributes): ?Message
    {

        if (empty($attributes['text']) && empty($attributes['images'])) {
            return null;
        }

        $message = DB::transaction(function () use ($room, $user, $attributes) {

            $message = $room->messages()->create(Arr::only($attributes, 'text') + ['user_id' => $user->id]);

            $this->sendImages->execute($message, Arr::only($attributes, 'images'));

            return $message;

        });

        broadcast(new MessageSent($message))->toOthers();
        broadcast(new RoomUpdated($message->room))->toOthers();

        return $message;

    }
}
