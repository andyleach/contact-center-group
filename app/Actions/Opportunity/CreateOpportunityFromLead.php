<?php

namespace App\Actions\Opportunity;

use App\Contracts\Opportunity\CreatesOpportunityContract;
use App\Models\Lead\Lead;
use App\Models\Opportunity\Opportunity;

/**
 * An opportunity indicates that a lead has achieved an actionable outcome for the client.
 */
class CreateOpportunityFromLead {
    public function handle(Lead $lead): Opportunity {
        return new Opportunity();
    }
}
