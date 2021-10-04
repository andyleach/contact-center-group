<?php


namespace App\Contracts;


use App\Exceptions\Task\TaskAssignmentException;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\User;


/**
 * InteractsWithTaskContract
 *
 * @category BetterCarPeople
 * @package  Core
 * @author   Andrew Leach <andrew.leach@bettercarpeople.com>
 * @license  Copyright Better Car People, LLC
 * @link     http://my.overnightbdc.com/
 */
interface TaskRepositoryInterface {
    /**
     * Responsible for taking a task and assigning it to a user when possible
     *
     * @param Task $task The task to be assigned
     * @param User $user The user who will be assigned the task
     *
     * @return Task
     * @throws TaskAssignmentException
     */
    public function assignTask(Task $task, User $user): Task;

    /**
     * @param Task $task
     * @param int|null $task_event_reason_id
     * @return Task
     * @throws TaskAssignmentException
     */
    public function cancelTaskAssignment(Task $task, int $task_event_reason_id = null): Task;

    /**
     * Marks a task as having expired and notifies the rest of the system
     *
     * @param Task $task                 The task we are marking as having expired
     * @param int  $task_event_reason_id The reason we have marked it as having expired
     * @return Task
     */
    public function expire(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task;
}
