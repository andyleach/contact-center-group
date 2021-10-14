<?php

namespace App\Events\Task;

/**
 * The system has indicated that the previously specified user is no longer responsible for the task, and it
 * should be returned to the general pool
 */
class TaskAssignmentCancelled extends AbstractTaskEvent
{

}

