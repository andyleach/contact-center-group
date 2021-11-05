<?php

namespace App\Http\Requests\Integrations;

use Illuminate\Foundation\Http\FormRequest;

class StoreTwilioInboundCallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Called	' => '', //"+17047033561"
            'ToState' => '', //	"NC"
            'CallerCountry' => '', //	"US"
            'Direction' => '', //	"inbound"
            'CallerState' => '', //	"NC"
            'ToZip' => '', //	"28202"
            'CallSid' => '', //	"CA6bc119efeb99b1c8429a1fae1e2676bd"
            'To' => '', //	"+17047033561"
            'CallerZip' => '', //	"28280"
            'ToCountry' => '', //	"US"
            'ApiVersion' => '', //	"2010-04-01"
            'CalledZip' => '', //	"28202"
            'CallStatus' => '', //	"ringing"
            'CalledCity' => '', //	"CHARLOTTE"
            'From' => '', //"+17043401925"
            'AccountSid' => '', //	"AC979228b263f7636f2882407c7285d4af"
            'CalledCountry' => '', //	"US"
            'CallerCity' => '', //	"CHARLOTTE"
            'Caller	' => '', //"+17043401925"
            'FromCountry' => '', //	"US"
            'ToCity' => '', //	"CHARLOTTE"
            'FromCity' => '', //	"CHARLOTTE"
            'CalledState' => '', //	"NC"
            'FromZip' => '', //	"28280"
            'FromState' => '', //	"NC"
        ];
    }
}
