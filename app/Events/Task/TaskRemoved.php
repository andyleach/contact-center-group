<?php

namespace App\Events\Task;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Any task with the Draft or Pending task status can change to the Removed task
 * status. Tasks with the In Process task status cannot be removed. After a task is removed,
 * it cannot change to another task status.
 */
class TaskRemoved extends AbstractTaskEvent
{

}
