<?php

namespace App\Events\Task;

/**
 * The user has closed the task, and the application is processing the closure. The Pending Close status typically
 * lasts only a moment. If the Pending Close status persists, the application has probably experienced an error
 * in the closing process.
 */
class TaskClosePending extends AbstractTaskEvent
{

}
