<?php

namespace App\Http\Services;

use App\Events\Lead\LeadImportCompleted;
use App\Events\Lead\LeadImportFailed;
use App\Events\Lead\LeadImportStarted;
use App\Models\Customer\Customer;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;

class LeadImportingService {

    /**
     * @param Lead $lead
     */
    public function import(Lead $lead) {

    }


}
