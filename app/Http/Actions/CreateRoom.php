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
        // Normalize inputs
        $user = $data['user'] ?? null;
        $authUser = $data['authUser'];

        // If there is a target user, try to find an existing two-user room
        if ($user !== null) {
            $ids = [$user->id, $authUser->id];

            $existing = $this->room
                ->whereHas('users', function ($q) use ($ids) {
                    $q->whereIn('users.id', $ids);
                }, '=', count($ids))
                ->whereDoesntHave('users', function ($q) use ($ids) {
                    $q->whereNotIn('users.id', $ids);
                })
                ->first();

            if ($existing) {
                return $existing;
            }
        }

        /** @var \App\Models\Room $room */
        $room = $this->room->create([
            'name' => $data['name'],
            'image_path' => null,
        ]);

        // Attach users: if a target user exists attach both, otherwise attach only the auth user
        if (isset($ids) && is_array($ids)) {
            $room->users()->attach($ids);
        } else {
            $room->users()->attach($authUser->id);
        }

        broadcast(new RoomCreated($room))->toOthers();

        return $room;

    }
}
