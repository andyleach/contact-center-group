<?php

namespace Database\Factories\Lead;

use App\Models\Lead\Lead;
use App\Models\Lead\LeadPhoneNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadPhoneNumberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeadPhoneNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone_number' => $this->faker->phoneNumber,
            'lead_id' => Lead::factory()->create()->id,
            'is_valid' => $this->faker->boolean
        ];
    }
}
