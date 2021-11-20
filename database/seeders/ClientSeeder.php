<?php

namespace Database\Seeders;

use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignStatus;
use App\Models\Client\Client;
use App\Models\Lead\Lead;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::factory()->count(15)->create();
    }
}
