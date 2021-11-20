<?php

namespace Database\Seeders;

use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignStatus;
use App\Models\Client\Client;
use App\Models\Lead\Lead;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            // TODO: Configure campaign events
            // TODO: Create at least one paused
            // TODO: Create at least one terminated
            // TODO: Create at least one completed
            $this->createFullyImportedCampaignsForClient($client, rand(1, 3));
            $this->createPartiallyImportedCampaignsForClient($client, rand(1, 3));
            $this->createNotImportedCampaignsForClient($client, rand(1,3));
        }
    }

    public function createFullyImportedCampaignsForClient(Client $client, int $count) {
        $campaigns = Campaign::factory()->for($client)->count($count)->create([
            'campaign_status_id' => CampaignStatus::IMPORT_COMPLETED,
            'start_work_at' => $startWorkAt = now()->subDay()
        ]);

        foreach ($campaigns as $campaign) {
            Lead::factory()->for($campaign)->for($client)->asRecentlyImported()->count(rand(5,20))->create([
                'import_at' => $startWorkAt->addSeconds(rand(20, 60))
            ]);
        }
    }

    public function createPartiallyImportedCampaignsForClient(Client $client, int $count) {
        $campaigns = Campaign::factory()->for($client)->count($count)->create([
            'campaign_status_id' => CampaignStatus::IMPORT_STARTED,
            'start_work_at' => $startWorkAt = now()->subDay()
        ]);

        foreach ($campaigns as $campaign) {
            // Recently imported
            Lead::factory()->for($campaign)->for($client)->asRecentlyImported()->count(rand(5,20))->create([
                'import_at' => $startWorkAt->addSeconds(rand(20, 60))
            ]);

            // For import now
            Lead::factory()->for($campaign)->for($client)->forImmediateImport()->count(rand(5,20))->create();

            // For import in the future
            Lead::factory()->for($campaign)->for($client)->forDelayedImport()->count(rand(5,20))->create();
        }
    }

    public function createNotImportedCampaignsForClient(Client $client, int $count) {

    }
}
