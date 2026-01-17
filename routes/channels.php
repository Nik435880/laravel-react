<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('room.{id}', fn($user) => $user);

Broadcast::channel('rooms', fn($user) => $user);
