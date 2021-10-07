<?php

namespace App\Domain\Task\Exceptions;

use Exception;

class TaskRemovalException extends Exception
{
    /**
     * @return TaskRemovalException
     */
    public static function default(): TaskRemovalException {
        return new static('Failed to remove the task from the queue');
    }
}
