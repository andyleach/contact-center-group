<?php

namespace Database\Factories\Sequence;

use App\Models\Sequence\Sequence;
use App\Models\Task\TaskType;
use App\Services\DataTransferObjects\SequenceActionData;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class SequenceActionDataFactory extends Factory
{
    protected $model = SequenceActionData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        'sequence_id' => "int",
        'task_type_id' => "int",
        'scheduled_start_time' => "string",
        'delay_in_seconds' => "int",
        'instructions' => "string",
        'ordinal_position' => "null"
    ])]
    public function definition(): array
    {
        return [
            'sequence_id' => Sequence::factory()->create()->id,
            'task_type_id' => $this->faker->randomElement(TaskType::ALL_TYPES),
            'scheduled_start_time' => $this->faker->time('H:i:s', '+30 days'),
            'delay_in_seconds' => 0,
            'instructions' => $this->faker->text,
            'ordinal_position' => null,
        ];
    }
}
