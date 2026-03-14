<?php

namespace App\Actions;

use App\Events\RoomCreated;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final readonly class CreateRoom
{
    public function __construct(
        private AddUser $addUser,
    ) {}

    /**
     * @param  array<Room>  $attributes
     */
    public function execute(array $attributes): Room
    {

        return DB::transaction(function () use ($attributes) {

            /** @var User $user */
            $user = Auth::user();

            $otherUser = User::query()
                ->where('name', $attributes['name'])
                ->first();

            if ($otherUser) {
                $existingRoom = Room::query()
                    ->where('name', $otherUser->name)
                    ->whereHas('users', fn($q) => $q->whereKey($user->id))
                    ->whereHas('users', fn($q) => $q->whereKey($otherUser->id))
                    ->has('users', '=', 2)
                    ->first();

                if ($existingRoom) {
                    return $existingRoom;
                }
            }

            $imagePath = null;

            if (isset($attributes['image']) && $attributes['image']) {
                $imagePath = $attributes['image']->store('room_images', 'public');
            }

            if (isset($attributes['image_path']) && $attributes['image_path']) {
                $imagePath = $attributes['image_path'];
            }

            $room = Room::create([
                'name' => $otherUser?->name ?? $attributes['name'],
                'image_path' => $imagePath,
            ]);


            $this->addUser->execute($user, $room);
            if ($otherUser) {
                $this->addUser->execute($otherUser, $room);
            }

            if (isset($attributes['users'])) {
                foreach ($attributes['users'] as $userId) {
                    /** @var User $user */
                    $user = User::find($userId);
                    if ($user) {
                        $this->addUser->execute($user, $room);
                    }
                }
            }

            RoomCreated::dispatch($room);

            return $room;
        });
    }
}
