<?php

namespace App\Exceptions\Task;

class TaskInProcessException extends \Exception {

    /**
     * @return TaskInProcessException
     */
    public static function default(): TaskInProcessException {
        return new static('Work has already begun on the task');
    }
}
