<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('room.{id}', function ($user) {
    return $user;
});

Broadcast::channel('rooms', function ($user) {
    return $user;
});
