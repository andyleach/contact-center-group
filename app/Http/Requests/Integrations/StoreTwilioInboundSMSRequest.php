<?php

namespace App\Http\Requests\Integrations;

use Illuminate\Foundation\Http\FormRequest;

class StoreTwilioInboundSMSRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * We are not performing any validation for this.  This class is a record of what is in a standard request
     *
     * @return array
     */
    public function rules(): array {
        return [
            "ToCountry" => "", // US
            "ToState" => "", // NC
            "SmsMessageSid" => "", // SMcdc70c6c7757daed4f60de500ac370ae
            "NumMedia" => "", // 0
            "ToCity" => "", // CHARLOTTE
            "FromZip" => "", // 28280
            "SmsSid" => "", // SMcdc70c6c7757daed4f60de500ac370ae
            // It's important to recognize that this field does not always exist on the request. START, STOP, HELP
            "OptOutType" => "", // STOP
            "FromState" => "", // NC
            "SmsStatus" => "", // received
            "FromCity" => "", // CHARLOTTE
            "Body" => "", // Stop
            "FromCountry" => "", // US
            "To" => "", // +17047033561
            "MessagingServiceSid" => "", // MG60deac9a5d3b7db496b712070452a57a
            "ToZip" => "", // 28202
            "NumSegments" => "", // 1
            "MessageSid" => "", // SMcdc70c6c7757daed4f60de500ac370ae
            "AccountSid" => "", // The account it was sent from
            "From" => "", // +17043401925
            "ApiVersion" => "", // 2010-04-01
        ];
    }
}

