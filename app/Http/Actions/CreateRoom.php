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
        $user = $data['user'] ?? null;
        $authUser = $data['authUser'];

        $ids = [$user->id, $authUser->id];

        $existing = $this->room
            ->whereHas('users', function ($q) use ($ids) {
                $q->whereIn('users.id', $ids);
            }, '>=', count($ids))
            ->whereDoesntHave('users', function ($q) use ($ids) {
                $q->whereNotIn('users.id', $ids);
            })
            ->first();

        if ($existing) {
            return $existing;
        }

        /** @var \App\Models\Room $room */
        $room = $this->room->create([
            'name' => $data['name'],
        ]);

        $room->users()->attach($ids);

        broadcast(new RoomCreated($room))->toOthers();

        return $room;

    }
}
