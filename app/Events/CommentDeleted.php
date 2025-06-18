<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommentDeleted implements ShouldBroadcast
{
    use SerializesModels;

    public $commentId;
    public $threadId;

    public function __construct($commentId, $threadId)
    {
        $this->commentId = $commentId;
        $this->threadId = $threadId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('thread.' . $this->threadId);
    }

    public function broadcastAs()
    {
        return 'CommentDeleted';
    }
}
