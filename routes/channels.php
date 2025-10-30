<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    // Hanya user yang punya ID sama dengan receiverId yang boleh dengar channel-nya
    return (int) $user->id === (int) $receiverId;
});

