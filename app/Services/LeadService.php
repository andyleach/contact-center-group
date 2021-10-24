<?php

namespace App\Services;

use App\Events\Lead\LeadDismissed;
use App\Events\Lead\LeadImportCompleted;
use App\Events\Lead\LeadImportFailed;
use App\Events\Lead\LeadImportStarted;
use App\Events\Lead\LeadReceived;
use App\Jobs\ImportLead;
use App\Jobs\ValidateLeadContactInformation;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use App\Models\LeadList\LeadList;
use App\Models\Sequence\Sequence;
use App\Models\Task\Task;
use App\Services\DataTransferObjects\LeadData;
use Illuminate\Support\Facades\Bus;

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
            'lead_list_id' => $data->lead_list_id,
            'meta_data' => $data->meta_data
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

    public function assignSequenceToLead(Lead $lead, Sequence $sequence): Lead {

    }

    public function createNextTaskInSequence(Lead $lead): Task {

    }

    public function endSequence(Lead $lead): Lead {

    }

    /**
     * @param LeadData $data
     * @return Lead
     */
    public function receiveLeadFromProvider(LeadData $data): Lead {
        // Create the new lead
        $lead = $this->createLead($data);

        LeadReceived::dispatch($lead);

        // Determine the best sequence to assign
        // Create the first task

        return $lead;
    }

    /**
     * @param LeadData $data
     * @return Lead
     */
    public function createLeadForLeadList(LeadList $leadList, LeadData $data): Lead {
        // Create the new lead
        $lead = $this->createLead($data);

        LeadReceived::dispatch($lead);

        // Determine the best sequence to assign
        // Create the first task

        return $lead;
    }
}
