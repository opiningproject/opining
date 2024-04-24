<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $chatData;
    private $userImage;
    private $createdAt;
    /**
     * Create a new event instance.
     */
    public function __construct($chatData, $userImage, $createdAt)
    {
        $this->chatData = $chatData;
        $this->userImage = $userImage;
        $this->createdAt = $createdAt;
    }

    public function broadcastWith()
    {
        return [
            'chat' => $this->chatData,
            'userImage' => $this->userImage,
            'createdAt' => $this->createdAt,
        ];
    }

    public function broadcastAs()
    {
        return 'getChatMessage';
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('brodcast-message'),
        ];
    }
}
