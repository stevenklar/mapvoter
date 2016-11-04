<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MapDismissed implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /** @var integer */
    private $matchId;

    /** @var mixed */
    public $data;

    public function __construct($matchId, $data)
    {
        $this->matchId = $matchId;
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new Channel('match.' . $this->matchId);
    }

    public function broadcastsAs()
    {
        return 'dismissed';
    }
}
