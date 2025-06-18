<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;

class ThreadPolicy
{
    /**
     * Determina si el usuario puede eliminar el hilo.
     */
    public function delete(User $user, Thread $thread): bool
    {
        return $user->id === $thread->user_id || $user->is_admin;
    }
}
