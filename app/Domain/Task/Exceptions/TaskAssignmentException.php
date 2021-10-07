<?php

namespace App\Domain\Task\Exceptions;

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

    /**
     * @return TaskAssignmentException
     */
    public static function taskCouldNotBeAssigned(): TaskAssignmentException {
        return new TaskAssignmentException('The task could not be assigned');
    }

    /**
     * @return TaskAssignmentException
     */
    public static function unableToCancelAssignment(): TaskAssignmentException {
        return new TaskAssignmentException('Unable to cancel assignment');
    }
}
