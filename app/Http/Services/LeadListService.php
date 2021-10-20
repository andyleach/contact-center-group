<?php

namespace App\Http\Services;

use App\Contracts\LeadServiceContract;
use App\Contracts\LeadListServiceContract;
use App\Events\LeadList\LeadListClosed;
use App\Events\LeadList\LeadListCompleted;
use App\Events\LeadList\LeadListConfirmed;
use App\Events\LeadList\LeadListImportingPaused;
use App\Events\LeadList\LeadListImportingResumed;
use App\Events\LeadList\LeadListSchedulingCompleted;
use App\Events\LeadList\LeadListSchedulingStarted;
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
     * @var LeadService $leadService
     */
    protected LeadService $leadService;

    public function __construct()
    {
        $this->leadService = new LeadService();
    }

    public function scheduleLeads(LeadList $leadList): LeadList {
        $dayLeadsScheduledForImport = $this->getFirstDayAvailableForSchedulingWork($leadList);

        LeadListSchedulingStarted::dispatch($leadList);

        /**
         * Find leads that haven't been scheduled, chunk them according to leads per day, and then schedule those leads
         * according to the maximum leads per day
         */
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

        LeadListSchedulingCompleted::dispatch($leadList);

        return $leadList;
    }

    public function close(LeadList $leadList): LeadList {
        $leadList->lead_list_status_id = LeadListStatus::COMPLETED;
        $leadList->save();

        LeadListClosed::dispatch($leadList);

        return $leadList;
    }

    public function confirm(LeadList $leadList): LeadList {
        $leadList->lead_list_status_id = LeadListStatus::CONFIRMED;
        $leadList->save();

        $this->scheduleLeads($leadList);

        LeadListConfirmed::dispatch($leadList);

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
            'client_id' => $data->client_id,
            'start_work_at' => $data->start_work_at
        ]);

        foreach ($data->leads as $lead) {
            $lead->lead_list_id = $leadList->id;
            $lead->lead_status_id = LeadStatus::DRAFT;
            $this->leadService->createLead($lead);
        }

        LeadListUploaded::dispatch($leadList);

        return $leadList;
    }

    public function pauseImporting(LeadList $leadList): LeadList {
        $leadList->lead_list_status_id = LeadListStatus::PAUSED;
        $leadList->save();

        $leadList->leadsNotImported()->update([
            'import_at' => null,
            'lead_status_id' => LeadStatus::DRAFT
        ]);

        LeadListImportingPaused::dispatch($leadList);

        return $leadList;
    }

    /**
     * @param LeadList $leadList
     * @return LeadList
     */
    public function resumeImporting(LeadList $leadList): LeadList {
        $leadList->lead_list_status_id = LeadListStatus::IMPORT_STARTED;
        $leadList->save();

        $leadList = $this->scheduleLeads($leadList);

        LeadListImportingResumed::dispatch($leadList);

        return $leadList;
    }

    /**
     * @param LeadList $leadList The lead list for which we want to determine whether or not we can begin scheduling work
     * @return Carbon
     */
    public function getFirstDayAvailableForSchedulingWork(LeadList $leadList): Carbon {
        $today = Carbon::now();

        $beginWorkAt = $leadList->start_work_at;
        // If the start date is in the past, start scheduling work beginning today
        if (false === $today->lessThanOrEqualTo($leadList->start_work_at)) {
            $beginWorkAt = $today;
        }

        return $beginWorkAt->startOfDay();
    }
}
