<?php

namespace Database\Factories\Task;

use App\Models\Lead\Lead;
use App\Models\Task\TaskType;
use App\Services\DataTransferObjects\TaskData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class TaskDataFactory extends Factory
{
    protected $model = TaskData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        'sequence_action_id' => "null",
        'task_type_id' => "int",
        'lead_id' => "int",
        'instructions' => "string",
        'available_at' => "\Carbon\Carbon",
        'expires_at' => "\Carbon\Carbon"
    ])]
    public function definition(): array
    {
        return [
            'sequence_action_id' => null,
            'task_type_id' => $this->faker->randomElement(TaskType::ALL_TYPES),
            'lead_id' => Lead::factory()->create()->id,
            'instructions' => $this->faker->text(200),
            'available_at' => $availableAt = Carbon::parse($this->faker->dateTimeBetween(now(), now()->addDays(30))),
            'expires_at'   => $availableAt->addDays(12)
        ];
    }
}
