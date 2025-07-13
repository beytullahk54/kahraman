<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $username;

    public function __construct($message, $username)
    {
        $this->message = $message;
        $this->username = $username ?? 'Anonim';
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        return 'NewMessage';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'username' => $this->username,
            'time' => now()->format('H:i:s')
        ];
    }
}