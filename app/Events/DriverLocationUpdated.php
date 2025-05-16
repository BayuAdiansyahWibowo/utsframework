<?php

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverLocationUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $driver;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function broadcastOn()
    {
        return new Channel('drivers');
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }
}
