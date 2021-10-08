<?php

namespace App\Domain\Agent\Events;

use App\Models\Agent\Agent;
use App\Models\User\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Indicates to the system that the user has begun winding down.  The system will stop assigning new tasks and allow
 * the user to complete the balance of those still assigned to them.
 */
class AgentBeganWindingDown {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Agent $agent
     */
    public Agent $agent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Agent $agent) {
        $this->agent = $agent;
    }

    public function broadcastWith(): array {
        return $this->agent->toArray();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('agent.' . $this->agent->id);
    }
}
