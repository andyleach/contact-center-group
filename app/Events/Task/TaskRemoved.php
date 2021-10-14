<?php

namespace App\Events\Task;

/**
 * Any task with the Draft or Pending task status can change to the Removed task
 * status. Tasks with the In Process task status cannot be removed. After a task is removed,
 * it cannot change to another task status.
 */
class TaskRemoved extends AbstractTaskEvent
{

}
