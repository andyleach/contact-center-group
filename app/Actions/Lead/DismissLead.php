<?php

namespace App\Actions\Lead;

use App\Events\Lead\LeadDismissed;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;

class DismissLead {
    /**
     * @param Lead $lead
     * @return Lead
     */
    public function handle(Lead $lead): Lead {
        $lead->lead_status_id = LeadStatus::DISMISSED;
        $lead->save();

        LeadDismissed::dispatch($lead);

        return $lead;
    }
}
