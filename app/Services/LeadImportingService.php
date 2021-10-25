<?php

namespace App\Services;

use App\Events\Lead\LeadImportCompleted;
use App\Events\Lead\LeadImportFailed;
use App\Events\Lead\LeadImportStarted;
use App\Models\Customer\Customer;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use Illuminate\Support\Collection;

class LeadImportingService {

    /**
     * @param Lead $lead
     * @return Collection
     */
    public function matchLeadToCustomerUsingContactInformation(Lead $lead): Collection {
        $phoneNumbers = $lead->leadPhoneNumbers->pluck('phone_number')->toArray();
        $emailAddresses = $lead->leadEmailAddresses->pluck('email_address')->toArray();

        return Customer::query()
            // Ensurer that we only match against customers belonging to the same client as the lead
            ->where('client_id', $lead->client_id)
            /**
             * Ensure that we only match against customers that have either a phone number of a email address in
             * common with our lead
             */
            ->where(function($query) use ($phoneNumbers, $emailAddresses) {
                $query->whereHas('customerPhoneNumbers', function($query) use ($phoneNumbers) {
                    $query->whereIn('phone_number', $phoneNumbers);
                })->orWhereHas('customerEmailAddresses', function($query) use ($emailAddresses) {
                    $query->whereIn('email_address', $emailAddresses);
                });
            })
            // Ensure that when we fetch the related records, we ONLY fetch the ones that had a match
            ->with([
                'customerPhoneNumbers' => function ($query) use ($phoneNumbers) {
                    $query->whereIn('phone_number', $phoneNumbers);
                },
                'customerEmailAddresses' => function ($query) use ($emailAddresses) {
                    $query->whereIn('email_address', $emailAddresses);
                }
            ])->get();
    }

    /**
     * Persists a record to the database
     * @param Lead     $lead
     * @param Customer $customer
     */
    public function storePointsOfCommonalityBetweenLeadAndCustomer(Lead $lead, Customer $customer) {
        // The total number of matched phone numbers
        $phoneNumberCount = $customer->customerPhoneNumbers->count();
        $emailAddressCount = $customer->customerEmailAddresses->count();

        // This is to be used to sort from most probable to least probable in terms of matches
        $totalPointsOfCommonality = $phoneNumberCount + $emailAddressCount;

        // Create an array of our columns to be updated on the pivot table for reuse down below
        $pivotData = [
            'matching_phone_numbers' => $phoneNumberCount,
            'matching_email_addresses' => $emailAddressCount,
            'total_points_of_commonality' => $totalPointsOfCommonality,
        ];

        /**
         * Checks to see if we already created the pivot. There is a unique key constraint to protect from
         * duplication, but we should still keep safeguards in the code.
         */
        $pivotExists = $customer->possibleRelatedLeads()
            ->wherePivot('lead_id', $lead->id)
            ->exists();

        // If the pivot exists, update the pivot with our newly queried data
        if (true == $pivotExists) {
            $customer->possibleRelatedLeads()->updateExistingPivot($lead->id, $pivotData);
        } else {
            // No pivot exists so we should save it for the first time
            $customer->possibleRelatedLeads()->save($lead, $pivotData);
        }
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
