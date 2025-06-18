<?php

namespace App\Notifications;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;


class ThreadCommented extends Notification implements ShouldBroadcast
{
    // Broadcasting: canal privado del usuario
    public function broadcastOn()
    {
        return ['private-App.Models.User.' . $this->thread->user->id];
    }

    // Tipo de evento para que Echo lo detecte como notificación estándar
    public function broadcastType()
    {
        return 'Illuminate\\Notifications\\Events\\BroadcastNotificationCreated';
    }

    public $thread;
    public $comment;

    public function __construct(Thread $thread, Comment $comment)
    {
        $this->thread = $thread;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'thread_id' => $this->thread->id,
            'thread_title' => $this->thread->title,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'comment_user_id' => $this->comment->user_id,
            'comment_user_name' => optional($this->comment->user)->name ?? 'Usuario',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
