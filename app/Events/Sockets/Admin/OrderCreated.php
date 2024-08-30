<?php

namespace App\Events\Sockets\Admin;

use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, InteractsWithBroadcasting;

    /**
     * Create a new event instance.
     */
    public function __construct(public float $total, public string $url)
    {
        logs()->info(self::class . ' => test');
        logs()->info('data', [$total, $url]);

        $this->broadcastVia('reverb');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'order.created.notify';
    }
}
