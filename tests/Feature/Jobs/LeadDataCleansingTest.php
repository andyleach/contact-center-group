<?php

namespace Tests\Feature\Jobs;

use App\Contacts\TwilioServiceContract;
use App\Jobs\ImportLead;
use App\Jobs\LeadDataCleansing;
use App\Models\Client\Client;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEmailAddress;
use App\Models\Customer\CustomerPhoneNumber;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadEmailAddress;
use App\Models\Lead\LeadPhoneNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Mocks\Services\Integrations\TwilioServiceFailureMock;
use Tests\TestCase;

class LeadDataCleansingTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_failed_twilio_requests_result_in_phone_numbers_being_marked_as_invalid()
    {
        $client = Client::factory()->create();

        // Create a lead with an email and phone number matching the ones we just created for the customer
        /** @var Lead $lead */
        $lead = Lead::factory()->for($client)->create();
        /** @var LeadPhoneNumber $leadPhoneNumber */
        $leadPhoneNumber = LeadPhoneNumber::factory()->for($lead)->create(['phone_number' => $this->faker->phoneNumber]);

        $this->app->bind(TwilioServiceContract::class, TwilioServiceFailureMock::class);

        $job = new LeadDataCleansing($lead);

        $job->handleClensingOfLeadPhoneNumbers();

        $this->assertDatabaseHas('lead_phone_numbers', [
            'id' => $leadPhoneNumber->id,
            'is_valid' => false
        ]);
    }
}
