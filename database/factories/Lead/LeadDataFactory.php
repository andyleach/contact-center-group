<?php

namespace Database\Factories\Lead;

use App\Models\Client\Client;
use App\Models\Lead\LeadProvider;
use App\Models\Lead\LeadStatus;
use App\Models\Lead\LeadType;
use App\Services\DataTransferObjects\LeadData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadDataFactory extends Factory {

    protected $model = LeadData::class;

    /**
     * @inheritDoc
     */
    public function definition():array {
        return [
            'client_id' => Client::factory()->create()->id,
            'lead_type_id' => $this->faker->randomElement([LeadType::SALES, LeadType::SERVICE]),
            'first_name' => $fName = $this->faker->firstName,
            'last_name' => $lName = $this->faker->lastName,
            'full_name' => $fName .' '. $lName,
            'primary_phone_number' => $this->faker->phoneNumber,
            'secondary_phone_numbers' => [
                $this->faker->phoneNumber,
                $this->faker->phoneNumber,
                $this->faker->phoneNumber,
            ],
            'primary_email_address' => $this->faker->email,
            'secondary_email_addresses' => [
                $this->faker->email,
                $this->faker->email,
                $this->faker->email,
            ],
            'import_at' => Carbon::parse($this->faker->dateTimeBetween('now', '+30 days')),
            'lead_provider_id' => LeadProvider::BETTER_CAR_PEOPLE,
            'lead_status_id' => $this->faker->randomElement([
                LeadStatus::DRAFT,
                LeadStatus::AWAITING_IMPORT,
                LeadStatus::IMPORT_STARTED,
                LeadStatus::IMPORT_FAILED,
                LeadStatus::IMPORT_COMPLETED,
                LeadStatus::WORKING,
                LeadStatus::COMPLETED,
                LeadStatus::CLOSED_SUBSCRIPTION_TERMINATED,
                LeadStatus::CLOSED_AGED,
                LeadStatus::DISMISSED
            ])
        ];
    }

    /**
     * Indicate that the user is suspended.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unscheduled(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'lead_status_id' => LeadStatus::DRAFT,
                'import_at' => now()
            ];
        });
    }
}
