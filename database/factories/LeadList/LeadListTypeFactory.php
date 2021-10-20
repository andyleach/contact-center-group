<?php

namespace Database\Factories\LeadList;

use App\Models\LeadList\LeadListType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadListTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeadListType::class;

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
