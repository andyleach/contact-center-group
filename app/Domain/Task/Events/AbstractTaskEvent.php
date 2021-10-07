<?php

namespace App\Domain\Task\Events;

use App\Domain\Task\Models\TaskEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AbstractTaskEvent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var TaskEvent $taskEvent
     */
    public TaskEvent $taskEvent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TaskEvent $taskEvent)
    {
        $this->taskEvent = $taskEvent;
    }

    /**
     * Only broadcast when we have an agent to broadcast to
     *
     * @return bool
     */
    public function broadcastWhen(): bool {
        return $this->taskEvent->user()->exists();
    }

    public function broadcastWith(): array {
        return [];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('user.' . $this->taskEvent->user_id);
    }
}
