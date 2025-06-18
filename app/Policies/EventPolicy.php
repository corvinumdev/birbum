<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Determine if the given event can be updated by the user.
     */
    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->is_admin;
    }

    /**
     * Determine if the given event can be deleted by the user.
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->is_admin;
    }
}
