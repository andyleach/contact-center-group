<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class StoreSequenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'label' => 'required|string|min:1',
            'description' => 'required|string|min:1',
            'client_id' => 'required|exists:clients,id',
            'cost_per_lead_in_usd' => 'required|decimal|min:0',
            'sequence_actions' => 'required|array',
            'sequence_actions.*' => [
                'task_type_id' => 'required|exists:task_types,id',
                'scheduled_start_time' => 'required|date_format:H:i',
                'delay_in_seconds' => 'required|number',
                'instructions' => 'required|string',
                'ordinal_position' => 'required|number'
            ]
        ];
    }
}
