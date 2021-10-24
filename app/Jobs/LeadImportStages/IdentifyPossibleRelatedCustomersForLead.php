<?php

namespace App\Jobs\LeadImportStages;

use App\Models\Customer\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class IdentifyPossibleRelatedCustomersForLead extends AbstractLeadImportStage implements ShouldQueue
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Collection|array<Customer> $customers */
        $customers = $this->identifyCustomersMatchingContactInformationForLead();
        foreach ($customers as $customer) {
            $this->logThatCustomerIsPossiblyRelatedToLeadInDatabase($customer);
        }
    }

    /**
     * @return Collection
     */
    public function identifyCustomersMatchingContactInformationForLead(): Collection {
        $phoneNumbers = $this->lead->leadPhoneNumbers->pluck('phone_number')->toArray();
        $emailAddresses = $this->lead->leadEmailAddresses->pluck('email_address')->toArray();

       return Customer::query()
           // Ensurer that we only match against customers belonging to the same client as the lead
           ->where('client_id', $this->lead->client_id)
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
     * @param Customer $customer
     */
    public function logThatCustomerIsPossiblyRelatedToLeadInDatabase(Customer $customer) {
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
            ->wherePivot('lead_id', $this->lead->id)
            ->exists();

        // If the pivot exists, update the pivot with our newly queried data
        if (true == $pivotExists) {
            $customer->possibleRelatedLeads()->updateExistingPivot($this->lead->id, $pivotData);
        } else {
            // No pivot exists so we should save it for the first time
            $customer->possibleRelatedLeads()->save($this->lead, $pivotData);
        }
    }
}
