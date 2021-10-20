<?php

namespace Database\Factories\Lead;

use App\Http\DataTransferObjects\LeadData;
use App\Models\Client\Client;
use App\Models\Lead\LeadProvider;
use App\Models\Lead\LeadType;
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
            'meta_data' => [
                'year' => $this->faker->year,
                'make' => 'Chevrolet',
                'model' => 'Camaro',
            ],
            'import_at' => Carbon::parse($this->faker->dateTimeBetween('now', '+30 days')),
            'lead_provider_id' => LeadProvider::BETTER_CAR_PEOPLE
        ];
    }
}