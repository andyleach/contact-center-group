<?php

namespace Database\Factories\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEmailAddress;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerEmailAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerEmailAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email_address' => $this->faker->email,
            'last_seen_at' => Carbon::parse($this->faker->dateTimeBetween('- year', 'now')),
            'customer_id' => Customer::factory()->create()->id,
        ];
    }
}
