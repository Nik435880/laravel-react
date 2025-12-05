<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $message;
    protected $room; // Add room reference

    /**
     * Create a new event instance.
     */
    public function __construct($message, $room)
    {
        $this->message = $message->load(['images', 'user.avatar']);
        $this->room = $room; // Assign the passed room to a property
    }

    public function getRoom()
    {
        return $this->room->id;
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'text' => $this->message->text,
                'user' => [
                    'name' => $this->message->user->name,
                    'avatar' => [
                        'avatar_path' => $this->message->user->avatar?->avatar_path ?? 'default.jpg'
                    ]
                ],
                'images' => $this->message->images->map(fn($image) => [
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                ])->toArray(),
                'created_at' => $this->message->created_at->toISOString(),
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
            new PresenceChannel('room.' . $this->getRoom()), // Use the updated room property here
        ];
    }
}
