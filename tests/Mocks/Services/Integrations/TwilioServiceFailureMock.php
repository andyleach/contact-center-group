<?php

namespace Tests\Mocks\Services\Integrations;


use App\Contracts\TwilioServiceContract;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Lookups\V1\PhoneNumberInstance;

/**
 * Designed to output expected failures from methods so we can test what happens upon a failure
 */
class TwilioServiceFailureMock implements TwilioServiceContract {
    /**
     * @param string $phoneNumber
     * @return PhoneNumberInstance
     * @throws TwilioException
     */
    public function lookup(string $phoneNumber): PhoneNumberInstance {
        throw new TwilioException('blah');
    }
}
