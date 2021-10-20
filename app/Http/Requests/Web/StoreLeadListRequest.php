<?php

namespace App\Http\Requests\Web;

use App\Rules\NowOrFutureDateRule;
use App\Rules\ValidateLeadRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeadListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'label' => 'required|now',
            'max_leads_to_import_per_day' => 'required|min:1',
            'lead_list_type_id' => 'required|exists:lead_list_types,id',
            'client_id' => 'required|exists:clients,id',
            'leads' => 'required|array',
            'start_work_at' => ['required', new NowOrFutureDateRule()],
            'leads.*' => [
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
            ]
        ];
    }
}
