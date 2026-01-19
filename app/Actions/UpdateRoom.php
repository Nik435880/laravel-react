<?php

namespace App\Actions;

use App\Events\RoomUpdated;
use App\Models\Room;

final class UpdateRoom
{
    public function execute(Room $room): Room
    {
        $room = $this->room->fresh();
        broadcast(new RoomUpdated($room))->toOthers();

        return $room;

    }
}
