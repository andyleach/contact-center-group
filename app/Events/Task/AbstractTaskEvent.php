<?php

namespace App\Events\Task;

use App\Models\Task\TaskEvent;
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
