<?php

namespace App\Services\DataTransferObjects;

use App\Http\Requests\Integrations\StoreTwilioInboundCallRequest;
use App\Models\Client\ClientPhoneNumber;
use App\Models\Provider\Provider;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InboundCallData extends AbstractDataTransferObject {
    use HasFactory;

    public int    $provider_id;
    public string $caller;
    public string $called;
    public string $call_sid;
    public string $account_sid;
    public ClientPhoneNumber $clientPhoneNumber;

    /**
     * Converts twilio call data into a standardized format that the system can work with.
     *
     * @param StoreTwilioInboundCallRequest $request
     * @return static
     */
    public static function fromTwilio(StoreTwilioInboundCallRequest $request): self {
        $data = new self;
        $data->provider_id = Provider::TWILIO;
        $data->call_sid = $request->get('CallSid');
        $data->called = $request->get('Called');
        $data->caller = $request->get('Caller');
        $data->account_sid = $request->get('AccountSid');

        // Find the client phone number or fail
        $data->clientPhoneNumber = ClientPhoneNumber::where('phone_number', $data->called)->firstOrFail();

        return $data;
    }
}
