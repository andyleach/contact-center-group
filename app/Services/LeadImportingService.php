<?php

namespace App\Services;

use App\Events\Lead\LeadImportCompleted;
use App\Events\Lead\LeadImportFailed;
use App\Events\Lead\LeadImportStarted;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEmailAddress;
use App\Models\Customer\CustomerPhoneNumber;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use App\Services\DataTransferObjects\LeadData;
use Illuminate\Support\Facades\DB;

class LeadImportingService {

    /**
     * @param LeadData $leadData
     * @return Customer|null
     */
    public function matchLeadDataToCustomer(LeadData $leadData): ?Customer {
        $result = $this->matchMostRecentlySeenCustomerContactInformation($leadData);

        return Customer::query()
            ->where('id', $result->customer_id)
            ->where('client_id', $leadData->client_id)
            ->first();
    }

    /**
     * @param LeadData $leadData
     * @return Customer|null
     */
    public function matchMostRecentlySeenCustomerContactInformation(LeadData $leadData): ?object {
        // Create query for lead matching based upon client customer phone numbers
        $query = CustomerPhoneNumber::query()
            ->matchClientCustomerPhoneNumber($leadData->client_id, $leadData->getAllPhoneNumbers())
            ->select([
                'id',
                'customer_id',
                'phone_number as value',
                'last_seen_at',
                \DB::raw("'phone' as type"),
            ]);

        // Create query for lead matching based upon client customer email addresses
        $queryTwo = CustomerEmailAddress::query()
            ->matchClientCustomerEmailAddress($leadData->client_id, $leadData->getAllEmailAddresses())
            ->select([
                'id',
                'customer_id',
                'email_address as value',
                'last_seen_at',
                \DB::raw("'email' as type")
            ]);

        return $queryTwo->unionAll($query)->orderByDesc('last_seen_at')->first();
    }

    public function matchLeadDataToCustomerPhoneNumber(LeadData $leadData) {
        // Match based upon customer phone numbers
        $customerPhoneNumberQuery = CustomerPhoneNumber::query()
            ->first();
    }


    public function startedImporting(Lead $lead): Lead {
        $lead->lead_status_id = LeadStatus::IMPORT_STARTED;
        $lead->save();

        LeadImportStarted::dispatch($lead);

        return $lead;
    }

    public function failedImporting(Lead $lead): Lead {
        $lead->lead_status_id = LeadStatus::IMPORT_FAILED;
        $lead->save();

        LeadImportFailed::dispatch($lead);

        return $lead;
    }

    public function completedImporting(Lead $lead): Lead {
        $lead->lead_status_id = LeadStatus::IMPORT_COMPLETED;
        $lead->save();

        LeadImportCompleted::dispatch($lead);

        return $lead;
    }
}
