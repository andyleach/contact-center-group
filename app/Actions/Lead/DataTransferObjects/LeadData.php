<?php

namespace App\Actions\Lead\DataTransferObjects;

use App\Http\Requests\Api\StoreLeadRequest;
use Carbon\Carbon;

class LeadData {
    public int $client_id;
    public int $lead_type_id;
    public string $first_name;
    public string $last_name;
    public string $full_name;
    public int $lead_provider_id;
    public Carbon $import_at;

    public static function fromRequest(StoreLeadRequest $request): self {
        $dto = new self;
        $dto->client_id = $request->get('client_id');
        $dto->lead_type_id = $request->get('lead_type_id');
        $dto->first_name = $request->get('first_name');
        $dto->last_name = $request->get('last_name');
        $dto->full_name = $request->get('full_name');
        $dto->import_at = now();

        return $dto;
    }

    public function setLeadProviderId(int $leadProviderId): self {
        $this->lead_provider_id = $leadProviderId;
        return $this;
    }
}
