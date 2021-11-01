<?php

namespace Database\Factories\Sequence;

use App\Models\Client\Client;
use App\Services\DataTransferObjects\SequenceData;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class SequenceDataFactory extends Factory
{
    protected $model = SequenceData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        'label' => "string",
        'description' => "string",
        'client_id' => "int",
        'cost_per_lead_in_usd' => "float"
    ])]
    public function definition(): array
    {
        return [
            'label' => $this->faker->text,
            'description' => $this->faker->text,
            'client_id' => Client::factory()->create()->id,
            'cost_per_lead_in_usd' => $this->faker->randomFloat(2, 10, 20)
        ];
    }
}
