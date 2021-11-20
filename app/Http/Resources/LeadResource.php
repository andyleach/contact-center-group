<?php

namespace App\Http\Resources;

use App\Models\Lead\Lead;
use App\Models\Lead\LeadProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    /**
     * @var Lead $resource
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
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'full_name' => $this->resource->full_name,
            // Client
            'client_id' => $this->resource->client_id,
            'client' => new ClientResource($this->resource->client),
            // Lead List
            'campaign_id' => $this->resource->campaign_id,
            'campaign' => new CampaignResource($this->resource->campaign),
            // Lead Type
            'lead_type_id' => $this->resource->lead_type_id,
            'lead_type' => new LeadTypeResource($this->resource->leadType),
            // Lead Status
            'lead_status_id' => $this->resource->lead_status_id,
            'lead_status' => new LeadStatusResource($this->resource->leadStatus),
            // Lead Disposition
            'lead_disposition_id' => $this->resource->lead_disposition_id,
            'lead_disposition' => new LeadDispositionResource($this->resource->leadDisposition),
            // Sequence
            'sequence_id' => $this->resource->sequence_id,
            'sequence' => new SequenceResource($this->resource->sequence),
            'last_sequence_action_identifier' => $this->resource->last_sequence_action_identifier,
            // Lead Provider
            'lead_provider_id' => $this->resource->lead_provider_id,
            'lead_provider' => new LeadProviderResource($this->resource->leadProvider),
            'meta_data' => $this->resource->meta_data,
            'import_at' => $this->resource->import_at
        ];
    }
}
