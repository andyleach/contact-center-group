<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\LocalInstance;

class AvailablePhoneNumbersResource extends JsonResource
{
    /**
     * @var LocalInstance $resource
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    #[ArrayShape([
        'phoneNumber' => "string",
        'locality' => "string",
        'region' => "string",
        'country' => "string"
    ])]
    public function toArray($request): array
    {
        return [
            'phoneNumber' => $this->resource->phoneNumber,
            'locality' => $this->resource->locality,
            'region' => $this->resource->region,
            'country' => $this->resource->isoCountry
        ];
    }
}
