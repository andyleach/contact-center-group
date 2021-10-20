<?php

namespace App\Events\Lead;

use App\Models\Lead\Lead;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractLeadEvent {
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var Lead $lead
     */
    protected Lead $lead;

    /**
     * Create a new event instance
     *
     * @return void
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
