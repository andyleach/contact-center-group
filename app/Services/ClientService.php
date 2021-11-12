<?php

namespace App\Services;

use App\Models\Client\Client;
use App\Models\Client\ClientPhoneNumber;
use App\Models\Client\ClientPhoneNumberStatus;
use App\Models\Provider\Provider;
use App\Services\Integrations\TwilioService;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

class ClientService {
    public function create() {

    }

    public function update() {

    }

    /**
     * Purchases a phone number for the client through our phone number provider
     *
     * @param Client $client The client the phone number is being purchased for
     * @param string $phoneNumber The phone number we are purchasing
     *
     * @return ClientPhoneNumber
     *
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function purchasePhoneNumber(Client $client, string $phoneNumber): ClientPhoneNumber {
        $twilioService = app(TwilioService::class);

        $friendlyName = $client->label .': '. $phoneNumber;

        $purchasedNumber = $twilioService->forClient($client)
            ->purchasePhoneNumber($phoneNumber, $friendlyName);

        $clientPhoneNumber = $client->clientPhoneNumbers()->create([
            'label' => $purchasedNumber->friendlyName,
            'phone_number' => $purchasedNumber->phoneNumber,
            'client_phone_number_status_id' => ClientPhoneNumberStatus::PURCHASED,
            'call_handling' => 'Route To Agent',
            'provider_sid' => $purchasedNumber->sid,
            'account_sid' => $purchasedNumber->accountSid,
            'provider_id' => Provider::TWILIO,
            'purchased_at' => now()
        ]);

        return $clientPhoneNumber;
    }
}
