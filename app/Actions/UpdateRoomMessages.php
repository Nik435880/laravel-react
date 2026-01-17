<?php

namespace App\Actions;

use App\Models\Room;
use App\Models\User;

final class UpdateRoomMessages
{
    public function __construct(
        private CreateMessage $createMessage,
    ) {}

    public function execute(array $attributes, Room $room, User $user): Room
    {
        $this->createMessage->execute($user, $room, $attributes);

        return $room;
    }
}
