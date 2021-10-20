<?php

namespace App\Http\Services;

use App\Contracts\LeadServiceContract;
use App\Contracts\LeadListServiceContract;
use App\Events\LeadList\LeadListClosed;
use App\Events\LeadList\LeadListCompleted;
use App\Events\LeadList\LeadListUploaded;
use App\Http\DataTransferObjects\LeadListData;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use App\Models\LeadList\LeadList;
use App\Models\LeadList\LeadListStatus;
use App\Models\Task\TaskStatus;
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
        $dayLeadsScheduledForImport = $this->getFirstDayAvailableForSchedulingWork($leadList);

        $leadList
            ->leadsAwaitingScheduling()
            ->chunk(
                $leadList->max_leads_to_import_per_day,
                function($leads) use ($leadList, $dayLeadsScheduledForImport) {
            $leadIds = [];
            foreach ($leads as $lead) {
                $leadIds[] = $lead->id;
            }

            Lead::whereIn('id', $leadIds)
                ->where('lead_list_id', $leadList->id)
                ->update([
                    'import_at' => $dayLeadsScheduledForImport,
                    'lead_status_id' => LeadStatus::AWAITING_IMPORT
                ]);

            $dayLeadsScheduledForImport->addDay();
        });

        return $leadList;
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
            $lead->lead_status_id = LeadStatus::DRAFT;
            $this->leadService->createLead($lead);
        }

        LeadListUploaded::dispatch($leadList);

        return $leadList;
    }

    public function rescheduleImportDateForLeadsAwaitingImport(LeadList $leadList, Carbon $startDay): LeadList {

    }

    /**
     * @param LeadList $leadList The lead list for which we want to determine whether or not we can begin scheduling work
     * @return Carbon
     */
    protected function getFirstDayAvailableForSchedulingWork(LeadList $leadList): Carbon {
        $today = Carbon::now();

        $beginWorkAt = $leadList->start_work_at;
        if (false === $today->lessThanOrEqualTo($leadList->start_work_at)) {
            $beginWorkAt = $today;
        }

        return $beginWorkAt->startOfDay();
    }
}
