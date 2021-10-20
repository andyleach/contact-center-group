<?php

namespace App\Events\LeadList;

use App\Models\LeadList\LeadList;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractLeadListEvent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var LeadList
     */
    public LeadList $leadList;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LeadList $leadList)
    {
        $this->leadList  = $leadList;
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
