<?php

namespace App\Services;

use App\Events\Campaign\CampaignClosed;
use App\Events\Campaign\CampaignCompleted;
use App\Events\Campaign\CampaignConfirmed;
use App\Events\Campaign\CampaignImportingPaused;
use App\Events\Campaign\CampaignImportingResumed;
use App\Events\Campaign\CampaignSchedulingCompleted;
use App\Events\Campaign\CampaignSchedulingStarted;
use App\Events\Campaign\CampaignUploaded;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignStatus;
use App\Services\DataTransferObjects\CampaignData;
use Carbon\Carbon;

class CampaignService {
    /**
     * @var LeadService $leadService
     */
    protected LeadService $leadService;

    public function __construct()
    {
        $this->leadService = new LeadService();
    }

    public function scheduleLeads(Campaign $campaign): Campaign {
        $dayLeadsScheduledForImport = $this->getFirstDayAvailableForSchedulingWork($campaign);

        CampaignSchedulingStarted::dispatch($campaign);

        /**
         * Find leads that haven't been scheduled, chunk them according to leads per day, and then schedule those leads
         * according to the maximum leads per day
         */
        $campaign
            ->leadsAwaitingScheduling()
            ->chunkById(
                $campaign->max_leads_to_import_per_day,
                function($leads) use ($campaign, $dayLeadsScheduledForImport) {
            $leadIds = [];
            foreach ($leads as $lead) {
                $leadIds[] = $lead->id;
            }

            Lead::whereIn('id', $leadIds)
                ->where('campaign_id', $campaign->id)
                ->update([
                    'import_at' => $dayLeadsScheduledForImport,
                    'lead_status_id' => LeadStatus::AWAITING_IMPORT
                ]);

            $dayLeadsScheduledForImport->addDay();
        }, 'id');

        CampaignSchedulingCompleted::dispatch($campaign);

        return $campaign;
    }

    public function close(Campaign $campaign): Campaign {
        $campaign->campaign_status_id = CampaignStatus::COMPLETED;
        $campaign->save();

        CampaignClosed::dispatch($campaign);

        return $campaign;
    }

    public function confirm(Campaign $campaign): Campaign {
        $campaign->campaign_status_id = CampaignStatus::CONFIRMED;
        $campaign->save();

        $this->scheduleLeads($campaign);

        CampaignConfirmed::dispatch($campaign);

        return $campaign;
    }

    public function complete(Campaign $campaign): Campaign {
        $campaign->campaign_status_id = CampaignStatus::COMPLETED;
        $campaign->save();

        CampaignCompleted::dispatch($campaign);

        return $campaign;
    }

    public function create(CampaignData $data): Campaign {
        $campaign = Campaign::create([
            'label' => $data->label,
            'max_leads_to_import_per_day' => $data->max_leads_to_import_per_day,
            'campaign_status_id' => $data->campaign_status_id,
            'campaign_type_id' => $data->campaign_type_id,
            'client_id' => $data->client_id,
            'start_work_at' => $data->start_work_at
        ]);

        foreach ($data->leads as $lead) {
            $lead->campaign_id = $campaign->id;
            $lead->lead_status_id = LeadStatus::DRAFT;
            $this->leadService->createLead($lead);
        }

        CampaignUploaded::dispatch($campaign);

        return $campaign;
    }

    public function pauseImporting(Campaign $campaign): Campaign {
        $campaign->campaign_status_id = CampaignStatus::PAUSED;
        $campaign->save();

        $campaign->leadsNotImported()->update([
            'import_at' => null,
            'lead_status_id' => LeadStatus::DRAFT
        ]);

        CampaignImportingPaused::dispatch($campaign);

        return $campaign;
    }

    /**
     * @param Campaign $leadList
     * @return Campaign
     */
    public function resumeImporting(Campaign $campaign): Campaign {
        $campaign->campaign_status_id = CampaignStatus::IMPORT_STARTED;
        $campaign->save();

        $campaign = $this->scheduleLeads($campaign);

        CampaignImportingResumed::dispatch($campaign);

        return $campaign;
    }

    /**
     * @param Campaign $campaign The lead list for which we want to determine whether or not we can begin scheduling work
     * @return Carbon
     */
    public function getFirstDayAvailableForSchedulingWork(Campaign $campaign): Carbon {
        $today = Carbon::now();

        $beginWorkAt = $campaign->start_work_at;
        // If the start date is in the past, start scheduling work beginning today
        if (false === $today->lessThanOrEqualTo($campaign->start_work_at)) {
            $beginWorkAt = $today;
        }

        return $beginWorkAt->startOfDay();
    }
}
