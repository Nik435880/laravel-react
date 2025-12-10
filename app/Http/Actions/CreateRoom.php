<?php

namespace App\Http\Actions;

use App\Events\RoomCreated;
use App\Models\Room;

final class CreateRoom
{
    public function __construct(
        private Room $room,
    ) {}

    public function execute(array $data): Room
    {

        $room = $this->room->create([
            'name' => $data['name'],
        ]);

        $room->users()->attach($data['user']);

        $room->users()->attach($data['authUser']);

        broadcast(new RoomCreated($room))->toOthers();

        return $room;

    }
}
