<?php

namespace Database\Factories\Agent;

use App\Models\Agent\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'user_id' => User::factory()->create()->id,
            'availability_type_id' => 1,
            'last_task_assigned_at' => now(),
        ];
    }
}
