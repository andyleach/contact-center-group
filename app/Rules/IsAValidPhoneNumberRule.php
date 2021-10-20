<?php

namespace App\Rules;

use App\Integrations\TwilioIntegration;
use Illuminate\Contracts\Validation\Rule;
use Twilio\Exceptions\TwilioException;

class IsAValidPhoneNumberRule implements Rule
{
    protected TwilioIntegration $integration;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->integration = new TwilioIntegration();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $phone_number = $this->integration->lookup($value);
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
