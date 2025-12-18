<?php

namespace App\Http\Actions;

use App\Events\MessageSent;
use App\Events\RoomUpdated;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;

final class CreateMessage
{
    public function __construct(
        private Message $message,

    ) {}

    public function execute(array $data): Message
    {
        /** @var \App\Models\Message $message */
        $message = $this->message->create([
            'text' => $data['text'] ?? null,
            'user_id' => $data['user_id'],
            'room_id' => $data['room_id'],
        ]);

        if (! empty($data['images'])) {
            foreach ($data['images'] as $imagePath) {
                $imagePath = Storage::disk('public')->put('images', $imagePath);
                $images = $message->images()->create([
                    'image_path' => $imagePath,
                ]);

            }
        }

        broadcast(new MessageSent($message))->toOthers();
        broadcast(new RoomUpdated($message->room))->toOthers();

        return $message;

    }
}
