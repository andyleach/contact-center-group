<?php

namespace Database\Factories\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPhoneNumber;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerPhoneNumberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerPhoneNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone_number' => $this->faker->phoneNumber,
            'last_seen_at' => Carbon::parse($this->faker->dateTimeBetween('- year', 'now')),
            'customer_id' => Customer::factory()->create()->id,
        ];
    }
}
