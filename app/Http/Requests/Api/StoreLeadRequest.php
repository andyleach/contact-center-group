<?php

namespace App\Http\Requests\Api;

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
        ];
    }
}
