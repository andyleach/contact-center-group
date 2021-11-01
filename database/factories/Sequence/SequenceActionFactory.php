<?php

namespace Database\Factories\Sequence;

use App\Models\Sequence\Sequence;
use App\Models\Sequence\SequenceAction;
use App\Models\Task\TaskType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class SequenceActionFactory extends Factory
{
    protected $model = SequenceAction::class;

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
            'scheduled_start_time' => Carbon::parse($this->faker->time('H:i:s', '+30 days')),
            'delay_in_seconds' => 0,
            'instructions' => $this->faker->text,
            'ordinal_position' => null,
        ];
    }
}
