<?php

namespace App\Services\DataTransferObjects;

use App\Http\Requests\Integrations\StoreTwilioInboundCallRequest;

class InboundCallData {
    public int    $provider_id;
    public string $caller;
    public string $called;
    public string $call_sid;
    public string $account_sid;

    public static function fromTwilio(StoreTwilioInboundCallRequest $request): self {

    }
}
