<?php

namespace App\Domain\Task\Exceptions;

class TaskInProcessException extends \Exception {

    /**
     * @return TaskInProcessException
     */
    public static function default(): TaskInProcessException {
        return new static('Work has already begun on the task');
    }
}
