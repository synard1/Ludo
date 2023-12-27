<?php

namespace Modules\Helpdesk\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewTicketEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticketData;
    
    /**
     * Create a new event instance.
     */
    public function __construct($ticketData)
    {
        $this->ticketData = $ticketData;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn()
    {
        return new Channel('new-ticket-channel');
    }
}
