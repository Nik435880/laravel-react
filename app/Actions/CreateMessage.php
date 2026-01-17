<?php

namespace App\Actions;

use App\Events\MessageSent;
use App\Events\RoomUpdated;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final readonly class CreateMessage
{
    public function __construct(
        private SendImages $sendImages,
    ) {}

    /**
     * @param  array<Message>  $attributes
     */
    public function execute(User $user, Room $room, array $attributes): ?Message
    {

        if (empty($attributes['text']) && empty($attributes['images'])) {
            return null;
        }

        $message = DB::transaction(function () use ($room, $user, $attributes): Message {

            $message = $room->messages()->create(Arr::only($attributes, 'text') + ['user_id' => $user->id]);
            assert($message instanceof Message);

            $this->sendImages->execute($message, Arr::only($attributes, 'images'));

            return $message;

        });

        broadcast(new MessageSent($message))->toOthers();
        broadcast(new RoomUpdated($room))->toOthers();

        return $message;

    }
}
