<?php

namespace App\Events\Task;

use App\Models\Task\Task;
use App\Models\Task\TaskEvent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Indicates that the task has been successfully created
 */
class TaskCreated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Task $tas
     */
    public Task $task;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->$task = $task;
    }
}
