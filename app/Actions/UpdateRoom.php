<?php

namespace App\Actions;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class UpdateRoom
{
    public function __construct(
        private CreateMessage $createMessage
    ) {}

    public function execute(array $attributes, Room $room): Room
    {
       $room->update($attributes);

        return $room;
    }
}
