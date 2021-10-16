<?php

namespace Database\Factories\Lead;

use App\Models\Client\Client;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadProvider;
use App\Models\Lead\LeadStatus;
use App\Models\Lead\LeadType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $fName = $this->faker->firstName,
            'last_name' => $lName = $this->faker->lastName,
            'full_name' => $fName .' '. $lName,
            'client_id' => Client::factory()->create([]),
            'lead_type_id' => $this->faker->randomElement([LeadType::SALES, LeadType::SERVICE]),
            'lead_status_id' => LeadStatus::RECEIVED,
            'lead_disposition_id' => null,
            'lead_provider_id' => LeadProvider::BETTER_CAR_PEOPLE,
            'sequence_id' => null,
            'last_sequence_action_identifier' => null,
        ];
    }
}
