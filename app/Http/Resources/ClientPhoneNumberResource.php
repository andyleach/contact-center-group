<?php

namespace App\Http\Resources;

use App\Models\Client\ClientPhoneNumber;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientPhoneNumberResource extends JsonResource
{
    /**
     * @var ClientPhoneNumber $resource
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'client_id' => $this->resource->client_id,
            'client_label' => $this->resource->client->label,

            'label' => $this->resource->label,
            'phone_number' => $this->resource->phone_number,
            'call_handling' => $this->resource->call_handling,
            'status_id' => $this->resource->client_phone_number_status_id,
            'status_label' => $this->resource->clientPhoneNumberStatus->label,
        ];
    }
}
