<?php

namespace Database\Factories\Campaign;

use App\Models\Campaign\CampaignType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CampaignType::class;

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
