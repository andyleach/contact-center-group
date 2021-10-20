<?php

namespace Database\Factories\LeadList;

use App\Http\DataTransferObjects\LeadData;
use App\Http\DataTransferObjects\LeadListData;
use App\Models\Client\Client;
use App\Models\Lead\LeadProvider;
use App\Models\Lead\LeadType;
use App\Models\LeadList\LeadListStatus;
use App\Models\LeadList\LeadListType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadListDataFactory extends Factory {

    protected $model = LeadListData::class;

    /**
     * @return array
     */
    public function definition():array {
        $client = Client::factory()->create();
        return [
            'label' => $this->faker->name,
            'max_leads_to_import_per_day' => 100,
            'lead_list_status_id' => LeadListStatus::CREATED,
            'lead_list_type_id' => LeadListType::factory()->create([])->id,
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
