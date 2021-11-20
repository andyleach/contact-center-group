<?php

namespace App\Services\DataTransferObjects;

use App\Http\Requests\Web\StoreCampaignRequest;
use App\Models\Campaign\CampaignStatus;
use Carbon\Carbon;
use Database\Factories\Campaign\CampaignDataFactory;
use Illuminate\Support\Collection;

class CampaignData extends AbstractDataTransferObject {

    public string $label;
    public int $max_leads_to_import_per_day;
    public int $campaign_status_id;
    public int $campaign_type_id;
    public int $client_id;
    public Carbon $start_work_at;
    /**
     * @var Collection $leads
     */
    public Collection $leads;

    /**
     * Ensures that you can use factories to create lead list data.  This means that you can start from the same baseline
     * by default when creating a new instance
     *
     * @return CampaignDataFactory
     */
    public static function newFactory(): CampaignDataFactory {
        return new CampaignDataFactory();
    }



    public static function fromRequest(StoreCampaignRequest $request): CampaignData {
         $data = new self;
         $data->label = $request->get('label');
         $data->client_id = $request->get('client_id');
         $data->max_leads_to_import_per_day = $request->get('max_leads_to_import_per_day');
         $data->campaign_type_id = $request->get('campaign_type_id');
         $data->campaign_status_id = CampaignStatus::CREATED;
         $data->start_work_at = Carbon::parse($request->get('start_work_at'));

        $leads = $request->get('leads');
        foreach ($leads as $lead) {
            $leadData = new LeadData($lead);
            $leadData->client_id = $data->client_id;
            $data->leads->push($leadData);
        }

        return $data;
    }
}
