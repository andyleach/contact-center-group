<?php

namespace Database\Factories\Task;

use App\Domain\Task\Models\Task;
use App\Domain\Task\Models\TaskStatus;
use App\Domain\Task\Models\TaskType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'task_type_id' => null,
            'task_status_id' => TaskStatus::PENDING,
            'task_disposition_id' => null,
            'user_id' => null,
            'unstructured_data' => [],
            'available_at' => now(),
            'assigned_at' => null,
            'expires_at' => null,
            'closed_at' => null,
        ];
    }
}
