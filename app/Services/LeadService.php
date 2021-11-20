<?php

namespace App\Services;

use App\Events\Lead\LeadDismissed;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use App\Services\DataTransferObjects\LeadData;

class LeadService {
    /**
     * @param LeadData $data
     * @return Lead
     */
    public function createLead(LeadData $data): Lead {
        $lead = Lead::create([
            'client_id' => $data->client_id,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'full_name' => $data->full_name,
            'lead_status_id' => $data->lead_status_id,
            'lead_disposition_id' => null,
            'lead_type_id' => $data->lead_type_id,
            'lead_provider_id' => $data->lead_provider_id,
            'campaign_id' => $data->campaign_id,
        ]);

        $phoneNumbers = $data->getAllPhoneNumbers();
        foreach ($phoneNumbers as $phoneNumber) {
            $lead->leadPhoneNumbers()->create([
                'phone_number' => $phoneNumber,
            ]);
        }

        $emailAddresses = $data->getAllEmailAddresses();
        foreach ($emailAddresses as $emailAddress) {
            $lead->leadEmailAddresses()->create([
                'email_address' => $emailAddress,
            ]);
        }

        return $lead;
    }

    /**
     * @param Lead $lead
     * @return Lead
     */
    public function dismissLead(Lead $lead): Lead {
        $lead->lead_status_id = LeadStatus::DISMISSED;
        $lead->save();

        LeadDismissed::dispatch($lead);

        return $lead;
    }
}
