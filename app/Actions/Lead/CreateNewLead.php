<?php

namespace App\Actions\Lead;

use App\Actions\Lead\DataTransferObjects\LeadData;
use App\Contracts\Lead\CreatesNewLeadContract;
use App\Events\Lead\LeadReceived;
use App\Models\Client\Client;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;

/**
 * Responsible for creating a new lead in our system
 *
 */
class CreateNewLead implements CreatesNewLeadContract {

    /**
     * @param LeadData $data
     * @return Lead
     */
    public function handle(LeadData $data): Lead {
        $client = Client::findOrFail($data->client_id);

        $lead = Lead::make([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'full_name' => $data->full_name,
            'lead_status_id' => LeadStatus::RECEIVED,
            'lead_disposition_id' => null,
            'lead_type_id' => $data->lead_type_id,
            'lead_provider_id' => $data->lead_provider_id
        ]);
        $client->leads()->save($lead);

        return $lead;
    }
}
