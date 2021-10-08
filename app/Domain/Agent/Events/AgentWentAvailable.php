<?php

namespace App\Domain\Agent\Events;

use App\Models\Agent\Agent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * The agent is now available for work, and tasks will soon begin being assigned to the user
 */
class AgentWentAvailable {
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
