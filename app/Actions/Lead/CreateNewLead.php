<?php

namespace App\Actions\Lead;

use App\Models\Client\Client;
use App\Models\Lead\Lead;

class CreateNewLead {
    public function handle(Client $client, array $leadData = []): Lead {
        $lead = Lead::make($leadData);
        $client->leads()->save($lead);

        return $lead;
    }
}
