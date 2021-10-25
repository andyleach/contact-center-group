<?php

namespace Tests\Feature\Jobs;

use App\Jobs\ImportLead;
use App\Jobs\LeadImportStages\DetermineIfLeadIsDuplicate;
use App\Jobs\LeadImportStages\IdentifyPossibleRelatedCustomersForLead;
use App\Jobs\LeadImportStages\IdentifySequenceToBeAssignedToLead;
use App\Models\Lead\Lead;
use Tests\TestCase;
use App\Models\Client\Client;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPhoneNumber;
use App\Models\Customer\CustomerEmailAddress;
use App\Models\Lead\LeadEmailAddress;
use App\Models\Lead\LeadPhoneNumber;

class ImportLeadTest extends TestCase
{
    public function test_that_related_leads_will_store_commonality_points() {
        $client = Client::factory()->create();

        // Crate a customer and one email and phone number
        /** @var Customer $customer */
        $customer = Customer::factory()->for($client)->create();
        $customerOnePhoneNumber = CustomerPhoneNumber::factory()->for($customer)->create();
        $customerOneEmailAddress = CustomerEmailAddress::factory()->for($customer)->create();

        // Create a lead with an email and phone number matching the ones we just created for the customer
        /** @var Lead $lead */
        $lead = Lead::factory()->for($client)->create();
        LeadEmailAddress::factory()->for($lead)->create(['email_address' => $customerOneEmailAddress->email_address]);
        LeadPhoneNumber::factory()->for($lead)->create(['phone_number' => $customerOnePhoneNumber->phone_number]);

        $job = new ImportLead($lead);

        $job->handleIdentifyingExistingCustomersWhichMayBeRelated();

        $this->assertDatabaseHas('customer_lead', [
            'customer_id' => $customer->id,
            'lead_id' => $lead->id,
            'matching_phone_numbers' => 1,
            'matching_email_addresses' => 1,
            'total_points_of_commonality' => 2,
        ]);
    }
}
