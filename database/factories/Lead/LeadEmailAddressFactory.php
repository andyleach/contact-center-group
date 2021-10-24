<?php

namespace Database\Factories\Lead;

use App\Models\Lead\Lead;
use App\Models\Lead\LeadEmailAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadEmailAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeadEmailAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email_address' => $this->faker->email,
            'lead_id' => Lead::factory()->create()->id,
            'is_valid' => $this->faker->boolean
        ];
    }
}
