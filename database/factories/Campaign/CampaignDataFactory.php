<?php

namespace Database\Factories\Campaign;

use App\Models\Client\Client;
use App\Models\Campaign\CampaignStatus;
use App\Models\Campaign\CampaignType;
use App\Services\DataTransferObjects\LeadData;
use App\Services\DataTransferObjects\CampaignData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignDataFactory extends Factory {

    protected $model = CampaignData::class;

    /**
     * @return array
     */
    public function definition():array {
        $client = Client::factory()->create();
        return [
            'label' => $this->faker->name,
            'max_leads_to_import_per_day' => 100,
            'campaign_status_id' => CampaignStatus::CREATED,
            'campaign_type_id' => CampaignType::factory()->create([])->id,
            'client_id' => $client->id,
            'start_work_at' => Carbon::parse($this->faker->dateTimeBetween('now', '+30 days')),
            'leads' => LeadData::factory()->unscheduled()->count(10)->make([
                'client_id' => $client->id
            ]),
        ];
    }

    /**
     * Indicate that the user is suspended.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forImmediateImport(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'start_work_at' => now(),
            ];
        });
    }

    /**
     * Indicate that the user is suspended.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forFutureWork(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'start_work_at' => now()->addDay(),
            ];
        });
    }
}
