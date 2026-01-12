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

    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message = $message->load(['images', 'user.avatar']);

    }


    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'text' => $this->message->text,
                'images' => $this->message->images->map(fn($image) => [
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                ])->toArray(),
                'user' => [
                    'id' => $this->message->user->id,
                    'name' => $this->message->user->name,
                    'email' => $this->message->user->email,
                    'avatar' => $this->message->user->avatar,
                ],
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
            new PresenceChannel('room.' . $this->message->room_id), // Use the updated room property here
        ];
    }
}
