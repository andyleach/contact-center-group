<?php

namespace Tests\Feature\Services;

use App\Jobs\LeadImportStages\IdentifyPossibleRelatedCustomersForLead;
use App\Models\Client\Client;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEmailAddress;
use App\Models\Customer\CustomerPhoneNumber;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadEmailAddress;
use App\Models\Lead\LeadPhoneNumber;
use App\Services\DataTransferObjects\LeadData;
use App\Services\LeadImportingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadImportingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected LeadImportingService $service;

    public function setUp(): void {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->service = new LeadImportingService();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_we_can_match_lead_data_to_a_customer_via_phone_number()
    {
        $client = Client::factory()->create();

        $customer = Customer::factory()->create([
            'client_id' => $client->id,
        ]);

        /** @var CustomerPhoneNumber $customerPhoneNumber */
        $customerPhoneNumber = CustomerPhoneNumber::factory()->create([
            'customer_id' => $customer->id
        ]);

        $leadData = new LeadData();

        $leadData->client_id = $client->id;
        $leadData->primary_phone_number = $customerPhoneNumber->phone_number;

        $matchedCustomer = CustomerPhoneNumber::query()
            ->matchClientCustomerPhoneNumber($leadData->client_id, $leadData->getAllPhoneNumbers())
            ->first();

        $this->assertInstanceOf(CustomerPhoneNumber::class, $matchedCustomer);
        $this->assertEquals($customer->id, $matchedCustomer->customer_id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_we_can_match_lead_data_to_a_customer_via_email_address()
    {
        $client = Client::factory()->create();

        $customer = Customer::factory()->create([
            'client_id' => $client->id,
        ]);

        /** @var CustomerEmailAddress $customerEmailAddress */
        $customerEmailAddress = CustomerEmailAddress::factory()->create([
            'customer_id' => $customer->id
        ]);

        $leadData = new LeadData();

        $leadData->client_id = $client->id;
        $leadData->primary_email_address = $customerEmailAddress->email_address;

        $matchedEmailAddress = CustomerEmailAddress::query()
            ->matchClientCustomerEmailAddress($leadData->client_id, $leadData->getAllEmailAddresses())
            ->first();

        $this->assertInstanceOf(CustomerEmailAddress::class, $matchedEmailAddress);
        $this->assertEquals($customer->id, $matchedEmailAddress->customer_id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_we_can_get_a_count_of_matched_phone_numbers_for_each_customer()
    {
        $client = Client::factory()->create();

        // Create one customer for the same client, and 3 phone numbers for that customer.
        /** @var Customer $customerOne */
        $customerOne = Customer::factory()->for($client)->create();
        $customerOnePhoneNumbers = CustomerPhoneNumber::factory()->for($customerOne)->count(3)->create();

        // Extract two of the created customer phone numbers which will later be attached to the lead
        $phoneNumbersToAddToLead = $customerOnePhoneNumbers->take(2)->pluck('phone_number');

        // Extract one of the lead phone numbers to be attached to a second customer phone number
        $sharedCustomerNumber = $phoneNumbersToAddToLead->first();

        // Create customer two and the associated customer phone number
        $customerTwo = Customer::factory()->for($client)->create();
        $customerTwoPhoneNumbers = CustomerPhoneNumber::factory()->for($customerTwo)->create([
            'phone_number' => $sharedCustomerNumber
        ]);

        // Create the lead with the 2 previously extract customer phone numbers
        /** @var Lead $lead */
        $lead = Lead::factory()->for($client)->create();
        LeadPhoneNumber::factory()->for($lead)->create(['phone_number' => $phoneNumbersToAddToLead->first()]);
        LeadPhoneNumber::factory()->for($lead)->create(['phone_number' => $phoneNumbersToAddToLead->last()]);

        $customers = $this->service->matchLeadToCustomerUsingContactInformation($lead);

        $customerOneReturned = $customers->where('id', $customerOne->id)->first();
        $this->assertEquals(2, $customerOneReturned->customerPhoneNumbers->count());

        $customerTwoReturned = $customers->where('id', $customerTwo->id)->first();
        $this->assertEquals(1, $customerTwoReturned->customerPhoneNumbers->count());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_we_can_get_a_count_of_matched_email_addresses_for_each_customer()
    {
        $client = Client::factory()->create();

        // Create one customer for the same client, and 3 phone numbers for that customer.
        $customerOne = Customer::factory()->for($client)->create();
        $customerOneEmailAddresses = CustomerEmailAddress::factory()->for($customerOne)->count(3)->create();

        // Extract two of the created customer phone numbers which will later be attached to the lead
        $emailAddressesToBeAddedToLead = $customerOneEmailAddresses->take(2)->pluck('email_address');

        // Extract one of the lead email addresses to be attached to a second customer
        $sharedCustomerEmailAddress = $emailAddressesToBeAddedToLead->first();

        // Create customer two and the associated customer phone number
        $customerTwo = Customer::factory()->for($client)->create();
        $customerTwoEmailAddress = CustomerEmailAddress::factory()->for($customerTwo)->create([
            'email_address' => $sharedCustomerEmailAddress
        ]);

        // Create the lead with the 2 previously extract customer phone numbers
        /** @var Lead $lead */
        $lead = Lead::factory()->for($client)->create();
        LeadEmailAddress::factory()->for($lead)->create(['email_address' => $emailAddressesToBeAddedToLead->first()]);
        LeadEmailAddress::factory()->for($lead)->create(['email_address' => $emailAddressesToBeAddedToLead->last()]);

        $customers = $this->service->matchLeadToCustomerUsingContactInformation($lead);

        $customerOneReturned = $customers->where('id', $customerOne->id)->first();
        $this->assertEquals(2, $customerOneReturned->customerEmailAddresses->count());

        $customerTwoReturned = $customers->where('id', $customerTwo->id)->first();
        $this->assertEquals(1, $customerTwoReturned->customerEmailAddresses->count());
    }

    public function test_that_phone_numbers_cannot_be_matched_across_clients() {
        $clientOne = Client::factory()->create();

        $customerOne = Customer::factory()->for($clientOne)->create();
        $customerOnePhoneNumber = CustomerPhoneNumber::factory()->for($customerOne)->create();

        $clientTwo = Client::factory()->create();

        // Create one customer for the same client, and 3 phone numbers for that customer.
        $customerTwo = Customer::factory()->for($clientTwo)->create();
        $customerTwoPhoneNumber = CustomerPhoneNumber::factory()->for($customerTwo)->create();

        // Create the lead with the 2 previously extract customer phone numbers
        /** @var Lead $lead */
        $lead = Lead::factory()->for($clientOne)->create();
        LeadPhoneNumber::factory()->for($lead)->create(['phone_number' => $customerOnePhoneNumber->phone_number]);
        LeadPhoneNumber::factory()->for($lead)->create(['phone_number' => $customerTwoPhoneNumber->phone_number]);

        $customers = $this->service->matchLeadToCustomerUsingContactInformation($lead);

        $customerOneReturned = $customers->where('id', $customerOne->id)->first();
        $this->assertEquals(1, $customerOneReturned->customerPhoneNumbers->count());

        $customerTwoReturned = $customers->where('id', $customerTwo->id)->first();
        $this->assertEquals(null, $customerTwoReturned);
    }

    public function test_that_email_addresses_cannot_be_matched_across_clients() {
        $clientOne = Client::factory()->create();

        $customerOne = Customer::factory()->for($clientOne)->create();
        $customerOneEmailAddresses = CustomerEmailAddress::factory()->for($customerOne)->create();

        $clientTwo = Client::factory()->create();

        // Create one customer for the same client, and 3 phone numbers for that customer.
        $customerTwo = Customer::factory()->for($clientTwo)->create();
        $customerTwoEmailAddresses = CustomerEmailAddress::factory()->for($customerTwo)->create();

        // Create the lead with the 2 previously extract customer phone numbers
        /** @var Lead $lead */
        $lead = Lead::factory()->for($clientOne)->create();
        LeadEmailAddress::factory()->for($lead)->create(['email_address' => $customerOneEmailAddresses->email_address]);
        LeadEmailAddress::factory()->for($lead)->create(['email_address' => $customerTwoEmailAddresses->email_address]);

        $customers = $this->service->matchLeadToCustomerUsingContactInformation($lead);

        $customerOneReturned = $customers->where('id', $customerOne->id)->first();
        $this->assertEquals(1, $customerOneReturned->customerEmailAddresses->count());

        $customerTwoReturned = $customers->where('id', $customerTwo->id)->first();
        $this->assertEquals(null, $customerTwoReturned);
    }
}
