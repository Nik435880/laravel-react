<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        protected Room $room,

    ) {
        //
    }

    public function broadcastWith()
    {
        return [
            'room' => [
                'id' => $this->room->id,
                'name' => $this->room->name,
                'messages' => $this->room->messages()->with('user:id,name,email')->latest()->take(1)->get()->reverse()->values(),
                'users' => $this->room->users()->with('avatar')->get(),
            ],

        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('rooms'),
        ];
    }
}
