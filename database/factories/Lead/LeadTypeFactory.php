<?php

namespace Database\Factories\Lead;

use App\Models\Lead\LeadType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeadType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->name
        ];
    }
}
