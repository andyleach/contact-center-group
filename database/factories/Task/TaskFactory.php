<?php

namespace Database\Factories\Task;

use App\Models\Lead\Lead;
use App\Models\Task\Task;
use App\Models\Task\TaskOriginationType;
use App\Models\Task\TaskStatus;
use App\Models\Task\TaskType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

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
    #[ArrayShape([
        'sequence_action_id' => "null",
        'task_type_id' => "int",
        'task_status_id' => "int",
        'lead_id' => "int",
        'instructions' => "string",
        'available_at' => "\Carbon\Carbon",
        'expires_at' => "\Carbon\Carbon",
        'task_origination_type_id' => "int",
    ])]
    public function definition(): array
    {
        return [
            'sequence_action_id' => null,
            'task_type_id' => $this->faker->randomElement(TaskType::ALL_TYPES),
            'task_status_id' => TaskStatus::PENDING,
            'lead_id' => Lead::factory()->create()->id,
            'instructions' => $this->faker->text(200),
            'available_at' => $availableAt = Carbon::parse($this->faker->dateTimeBetween(now(), now()->addDays(30))),
            'expires_at'   => $availableAt->addDays(12),
            'task_origination_type_id' => $this->faker->randomElement([
                TaskOriginationType::MATCHED_INBOUND_ACTIVITY,
                TaskOriginationType::UNMATCHED_INBOUND_ACTIVITY,
                TaskOriginationType::SEQUENCE
            ])
        ];
    }
}
