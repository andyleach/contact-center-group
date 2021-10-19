<?php

namespace App\Http\Requests\Api;

use App\Rules\NowOrFutureDateRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: Add authorization on the level of the lead provider
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'lead_type_id' => 'required|exists:lead_types,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'full_name' => 'required|string',

            // Perform validation on phone numbers
            'primary_phone_number' => 'sometimes|string',
            'secondary_phone_numbers' => 'required|array',
            'secondary_phone_numbers.*' => 'string',

            // Perform validation on email addresses
            'primary_email_address' => 'sometimes|email:rfc,dns',
            'secondary_email_addresses' => 'required|array',
            'secondary_email_addresses.*' => 'string|email:rfc,dns',

            'meta_data' => 'sometimes|array',
            'import_at' => ['required', new NowOrFutureDateRule()]
        ];
    }
}
