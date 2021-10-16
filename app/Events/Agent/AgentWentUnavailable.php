<?php

namespace App\Events\Agent;

use App\Models\Agent\Agent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Indicates that the user is no longer available to perform work. No new tasks will be assigned, and all existing
 * tasks that were assigned have been closed out.
 */
class AgentWentUnavailable {
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
