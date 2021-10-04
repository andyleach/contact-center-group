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
    public static function notAssignedToUser(): TaskAssignmentException {
        return new TaskAssignmentException('This task is no longer assigned to you');
    }

    public static function taskHasAlreadyBeenAssigned(): TaskAssignmentException {
        return new TaskAssignmentException('The task has already been assigned');
    }

    public static function unableToCancelAssignment(): TaskAssignmentException {
        return new TaskAssignmentException('Unable to cancel assignment');
    }
}
