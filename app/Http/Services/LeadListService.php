<?php

namespace App\Http\Services;

use App\Contracts\LeadServiceContract;
use App\Contracts\LeadListServiceContract;
use App\Events\LeadList\LeadListClosed;
use App\Events\LeadList\LeadListCompleted;
use App\Events\LeadList\LeadListUploaded;
use App\Http\DataTransferObjects\LeadListData;
use App\Models\LeadList\LeadList;
use App\Models\LeadList\LeadListStatus;
use Carbon\Carbon;

class LeadListService implements LeadListServiceContract {
    /**
     * @var LeadServiceContract $leadService
     */
    protected LeadServiceContract $leadService;

    public function __construct()
    {
        $this->leadService = app(LeadServiceContract::class);
    }

    public function scheduleLeads(LeadList $leadList): LeadList {

    }

    public function close(LeadList $leadList): LeadList {
        $leadList->lead_list_status_id = LeadListStatus::COMPLETED;
        $leadList->save();

        LeadListClosed::dispatch($leadList);

        return $leadList;
    }

    public function confirm(LeadList $leadList): LeadList {
        $leadList->lead_list_status_id = LeadListStatus::COMPLETED;
        $leadList->save();

        LeadListCompleted::dispatch($leadList);

        return $leadList;
    }

    public function complete(LeadList $leadList): LeadList {
        $leadList->lead_list_status_id = LeadListStatus::COMPLETED;
        $leadList->save();

        LeadListCompleted::dispatch($leadList);

        return $leadList;
    }

    public function create(LeadListData $data): LeadList {
        $leadList = LeadList::create([
            'label' => $data->label,
            'max_leads_to_import_per_day' => $data->max_leads_to_import_per_day,
            'lead_list_status_id' => $data->lead_list_status_id,
            'lead_list_type_id' => $data->lead_list_type_id,
            'client_id' => $data->client_id
        ]);

        foreach ($data->leads as $lead) {
            $lead->lead_list_id = $leadList->id;
            $this->leadService->createLead($lead);
        }

        LeadListUploaded::dispatch($leadList);

        return $leadList;
    }

    public function rescheduleImportDateForLeadsAwaitingImport(LeadList $leadList, Carbon $startDay): LeadList {

    }
}
