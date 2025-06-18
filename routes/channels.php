<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

// Canal privado para comentarios en hilos
Broadcast::channel('thread.{threadId}', function ($user, $threadId) {
    Log::info('[Broadcast] Autenticando canal thread.' . $threadId, [
        'user_id' => $user ? $user->id : null,
        'user' => $user,
        'threadId' => $threadId,
        'is_authenticated' => (bool) $user,
    ]);
    return (bool) $user;
});

// Canal privado para notificaciones de usuario (Laravel Notifications)
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
