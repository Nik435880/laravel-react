<?php

namespace App\Actions;

use App\Events\RoomUpdated;
use App\Models\Room;

final class UpdateRoom
{
    public function execute(array $attributes, Room $room): Room
    {
        $room->messages()->create($attributes);
        RoomUpdated::dispatch($room);
        return $room;
    }
}
