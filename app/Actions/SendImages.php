<?php

namespace App\Actions;

use App\Models\Message;
use Illuminate\Support\Facades\Storage;

class SendImages
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function execute(Message $message, array $attributes): void
    {
        if (!isset($attributes['images'])) {
            return;
        }

        foreach ($attributes['images'] as $image) {
            $imagePath = $image->store('images', 'public');
            $message->images()->create([
                'image_path' => $imagePath,
            ]);

        }

    }
}
