<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewComment implements ShouldBroadcast
{
    use SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment->load('user');
        // Añadimos el campo de fecha humana para el frontend
        $this->comment->created_at_human = $comment->created_at->diffForHumans();
    }

    public function broadcastOn()
    {
        return new PrivateChannel('thread.' . $this->comment->thread_id);
    }

    public function broadcastAs()
    {
        return 'NewComment';
    }
}
