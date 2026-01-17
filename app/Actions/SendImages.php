<?php

namespace App\Actions;

use App\Models\Message;
use Illuminate\Support\Facades\Storage;

class SendImages
{
    public function execute(Message $message, array $attributes)
    {
        if (! isset($attributes['images']) || empty($attributes['images'])) {
            return;
        }

        foreach ($attributes['images'] as $imagePath) {
            $imagePath = Storage::disk('public')->put('images', $imagePath);
            $images = $message->images()->create([
                'image_path' => $imagePath,
            ]);

        }

    }
}
