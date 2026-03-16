<?php

namespace App\Actions;

use App\Events\RoomCreated;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class CreateRoom
{
    public function __construct(
    ) {}

    /**
     * @param  array<Room>  $attributes
     */
    public function execute(array $attributes): Room
    {

        return DB::transaction(function () use ($attributes) {
            $imagePath = null;

            if (isset($attributes['image'])) {
                $imagePath = $attributes['image']->store('room_images', 'public');
            }

            if (isset($attributes['image_path'])) {
                $imagePath = $attributes['image_path'];
            }

            $room = Room::create([
                'name' => $attributes['name'],
                'image_path' => $imagePath,
            ]);

            RoomCreated::dispatch($room);

            return $room;
        });
    }
}
