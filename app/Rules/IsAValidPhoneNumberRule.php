<?php

namespace App\Rules;

use App\Services\Integrations\TwilioService;
use Illuminate\Contracts\Validation\Rule;
use Twilio\Exceptions\TwilioException;

class IsAValidPhoneNumberRule implements Rule
{
    protected TwilioService $integration;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->integration = new TwilioService();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            $phone_number = $this->integration->lookup($value);
            return true;
        } catch (TwilioException $exception) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
