<?php

namespace Tests\Feature\Services;

use App\Models\Client\Client;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEmailAddress;
use App\Models\Customer\CustomerPhoneNumber;
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
    public function test_that_when_a_customer_phone_number_was_seen_most_recently_that_we_will_match_to_the_phone_number()
    {
        /** @var Client $client */
        $client = Client::factory()->create();

        /** @var Customer $customer */
        $customer = Customer::factory()->create([
            'client_id' => $client->id,
        ]);

        /** @var CustomerEmailAddress $customerEmailAddress */
        $customerEmailAddress = CustomerEmailAddress::factory()->create([
            'customer_id' => $customer->id,
            'last_seen_at' => now()->subDay()
        ]);

        /** @var CustomerPhoneNumber $customerPhoneNumber */
        $customerPhoneNumber = CustomerPhoneNumber::factory()->create([
            'customer_id' => $customer->id,
            'last_seen_at' => now(),
        ]);

        $leadData = new LeadData();

        $leadData->client_id = $client->id;
        $leadData->primary_email_address = $customerEmailAddress->email_address;
        $leadData->primary_phone_number  = $customerPhoneNumber->phone_number;

        $result = $this->service->matchMostRecentlySeenCustomerContactInformation($leadData);
        $this->assertEquals('phone', $result->type);
        $this->assertEquals($customerPhoneNumber->id, $result->id);
        $this->assertEquals($customer->id, $result->customer_id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_we_can_match_a_lead_to_a_customer()
    {
        /** @var Client $client */
        $client = Client::factory()->create();

        /** @var Customer $customer */
        $customer = Customer::factory()->create([
            'client_id' => $client->id,
        ]);

        /** @var CustomerEmailAddress $customerEmailAddress */
        $customerEmailAddress = CustomerEmailAddress::factory()->create([
            'customer_id' => $customer->id,
            'last_seen_at' => now()->subDay()
        ]);

        $leadData = new LeadData();

        $leadData->client_id = $client->id;
        $leadData->primary_email_address = $customerEmailAddress->email_address;

        $matchedCustomer = $this->service->matchLeadDataToCustomer($leadData);

        $this->assertInstanceOf(Customer::class, $matchedCustomer);
        $this->assertEquals($customer->id, $matchedCustomer->id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_when_contact_information_is_seen_on_two_different_customers_we_identify_who_saw_it_most_recently()
    {
        /** @var Client $client */
        $client = Client::factory()->create();

        /** @var Customer $olderCustomer */
        $olderCustomer = Customer::factory()->create([
            'client_id' => $client->id,
        ]);

        /** @var CustomerEmailAddress $olderCustomerEmailAddress */
        $olderCustomerEmailAddress = CustomerEmailAddress::factory()->create([
            'customer_id' => $olderCustomer->id,
            'last_seen_at' => now()->subDay()
        ]);

        /** @var Customer $newerCustomer */
        $newerCustomer = Customer::factory()->create([
            'client_id' => $client->id,
        ]);

        /** @var CustomerEmailAddress $newerCustomerEmailAddress */
        $newerCustomerEmailAddress = CustomerEmailAddress::factory()->create([
            'customer_id' => $newerCustomer->id,
            'email_address' => $olderCustomerEmailAddress->email_address,
            'last_seen_at' => now()
        ]);

        $leadData = new LeadData();

        $leadData->client_id = $client->id;
        $leadData->primary_email_address = $newerCustomerEmailAddress->email_address;

        $matchedCustomer = $this->service->matchLeadDataToCustomer($leadData);

        $this->assertInstanceOf(Customer::class, $matchedCustomer);
        $this->assertEquals($newerCustomer->id, $matchedCustomer->id);
    }
}
