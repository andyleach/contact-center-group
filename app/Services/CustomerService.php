<?php

namespace App\Services;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEmailAddress;
use App\Models\Customer\CustomerPhoneNumber;
use App\Models\Lead\Lead;
use App\Services\DataTransferObjects\LeadData;

class CustomerService {
    public function addPhoneNumberToCustomer(Customer $customer, string $phoneNumber): CustomerPhoneNumber {
        /** @var CustomerPhoneNumber $phoneNumber */
        $phoneNumber = $customer->customerPhoneNumbers()->updateOrCreate([
            'phone_number' => $phoneNumber,
        ], [
            'phone_number' => $phoneNumber,
            'last_seen_at' => now(),
        ]);

        return $phoneNumber;
    }

    public function createCustomerFromLead(Lead $lead): Customer {
        $customer = new Customer();
        $customer->leads()->save($lead);
    }

    public function addEmailAddressToCustomer(Customer $customer, string $emailAddress): CustomerEmailAddress {
        /** @var CustomerEmailAddress $emailAddress */
        $emailAddress = $customer->customerEmailAddresses()->updateOrCreate([
            'email_address' => $emailAddress,
        ], [
            'email_address' => $emailAddress,
            'last_seen_at' => now(),
        ]);

        return $emailAddress;
    }
}
