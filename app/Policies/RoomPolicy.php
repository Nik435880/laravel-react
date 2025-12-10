<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;

class RoomPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Room $room): bool
    {
        return $room->users()->where('user_id', $user->id)->exists();
    }

    public function create(User $user) 
    {
        return true;
    
    }

    public function update(User $user, Room $room): bool
    {
        return false;
    }

    public function delete(User $user, Room $room): bool
    {
        return false;
    }



}
