<?php

namespace App\Exceptions\Task;

use Exception;

/**
 * Used to indicate errors surrounding the assignment of a task to a user
 */
class TaskAssignmentException extends Exception
{
    /**
     * @return TaskAssignmentException
     */
    public static function noLongerAssignedToUser(): TaskAssignmentException {
        return new TaskAssignmentException('This task is no longer assigned to you');
    }
}
