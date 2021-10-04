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
 * The user has closed the task, and the application is processing the closure. The Pending Close status typically
 * lasts only a moment. If the Pending Close status persists, the application has probably experienced an error
 * in the closing process.
 */
class TaskClosePending extends AbstractTaskEvent
{

}
