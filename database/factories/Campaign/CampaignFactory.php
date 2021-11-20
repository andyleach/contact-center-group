<?php

namespace Database\Factories\Campaign;

use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignStatus;
use App\Models\Campaign\CampaignType;
use App\Models\Client\Client;
use App\Services\DataTransferObjects\LeadData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->name,
            'max_leads_to_import_per_day' => 100,
            'campaign_status_id' => CampaignStatus::CREATED,
            'campaign_type_id' => CampaignType::factory()->create([])->id,
            'client_id' => Client::factory()->create()->id,
            'start_work_at' => Carbon::parse($this->faker->dateTimeBetween('now', '+30 days')),
        ];
    }
}
