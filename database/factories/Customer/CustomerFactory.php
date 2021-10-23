<?php

namespace Database\Factories\Customer;

use App\Models\Client\Client;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var Client $client */
        $client = Client::factory()->create();
        return [
            'first_name' => $fName = $this->faker->firstName,
            'last_name' => $lName = $this->faker->lastName,
            'full_name' => $fName .' '. $lName,
            'client_id' => $client->id,
        ];
    }
}
