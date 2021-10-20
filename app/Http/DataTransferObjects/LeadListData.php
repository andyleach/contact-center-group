<?php

namespace App\Http\DataTransferObjects;

use App\Http\Requests\Api\StoreLeadRequest;
use App\Http\Requests\Web\StoreLeadListRequest;
use App\Models\Lead\LeadStatus;
use App\Models\LeadList\LeadListStatus;
use Carbon\Carbon;
use Database\Factories\Lead\LeadDataFactory;
use Database\Factories\LeadList\LeadListDataFactory;

class LeadListData extends AbstractDataTransferObject {

    public string $label;
    public int $max_leads_to_import_per_day;
    public int $lead_list_status_id;
    public int $lead_list_type_id;
    public int $client_id;
    public array $leads = [];

    /**
     * Ensures that you can use factories to create lead list data.  This means that you can start from the same baseline
     * by default when creating a new instance
     *
     * @return LeadListDataFactory
     */
    public static function newFactory(): LeadListDataFactory {
        return new LeadListDataFactory();
    }

    public static function fromRequest(StoreLeadListRequest $request): LeadListData {
         $data = new self;
         $data->label = $request->get('label');
         $data->max_leads_to_import_per_day = $request->get('max_leads_to_import_per_day');
         $data->lead_list_type_id = $request->get('lead_list_type_id');
         $data->lead_list_status_id = LeadListStatus::CREATED;

        $leads = $request->get('leads');
        foreach ($leads as $lead) {
            $data->leads[] = new LeadData($lead);
        }

        return $data;
    }
}
