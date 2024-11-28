<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $url;
    public $avatar_url;
    public $userId;

    public function __construct(mixed $message, mixed $userId, mixed $url, mixed $avatar_url)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->url = $url;
        $this->avatar_url = $avatar_url;
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'url' => $this->url,
            'avatar_url' => $this->avatar_url
        ];
    }
    public function broadcastOn()
    {
        return ["user.{$this->userId}"];
    }

    public function broadcastAs()
    {
        return 'push-notification';
    }
}
