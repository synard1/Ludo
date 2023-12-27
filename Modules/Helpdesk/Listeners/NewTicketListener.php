<?php

namespace Modules\Helpdesk\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Helpdesk\Events\NewTicketEvent;

class NewTicketListener
{
    // use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewTicketEvent $event)
    {
        // Handle the event data, for example, send a notification
        // This is optional and depends on your use case
        // You can log, send emails, etc.
        info('New Ticket Event Received', ['data' => $event->ticketData]);
    }
}
