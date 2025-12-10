<?php

namespace App\Http\Actions;

use App\Events\RoomUpdated;
use App\Models\Room;

final class UpdateRoom
{
    public function __construct(
        private Room $room,
    ) {}

    public function execute(): Room
    {
        $room = $this->room->fresh();
        broadcast(new RoomUpdated($room))->toOthers();

        return $room;

    }
}
