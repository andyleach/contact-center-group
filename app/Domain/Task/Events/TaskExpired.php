<?php

namespace App\Domain\Task\Events;

/**
 * Indicates that the task has reached the date and time which makes it no longer viable for work.
 */
class TaskExpired extends AbstractTaskEvent
{

}

