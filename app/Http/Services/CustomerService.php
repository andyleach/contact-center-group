<?php

namespace App\Http\Services;

use App\Models\Customer\Customer;
use App\Models\Lead\Lead;

class CustomerService {
    public function matchLeadToCustomer(Lead $lead): Customer {

    }

    public function createCustomerFromLead(Lead $lead): Customer {
        $customer = new Customer();
        $customer->leads()->save($lead);

    }

    public function addPhoneNumberToCustomer(Customer $customer, string $phoneNumber) {

    }

    public function addEmailAddressToCustomer(Customer $customer, string $emailAddress) {

    }

    public function removePhoneNumberFromCustomer(Customer $customer, string $phoneNumber) {

    }

    public function removeEmailAddressFromCustomer(Customer $customer, string $emailAddress) {

    }
}
