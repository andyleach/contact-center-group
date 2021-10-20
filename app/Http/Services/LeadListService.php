<?php

namespace App\Http\Services;

use App\Http\DataTransferObjects\LeadListData;
use App\Models\Lead\Lead;
use App\Models\LeadList\LeadList;
use Carbon\Carbon;

class LeadListService {
    public function calendaize(LeadList $leadList): LeadList {

    }

    public function close(LeadList $leadList): LeadList {

    }

    public function confirm(LeadList $leadList): LeadList {

    }

    public function complete(LeadList $leadList): LeadList {

    }

    public function create(LeadListData $data): LeadList {

        return new LeadList();
    }

    public function rescheduleImportDateForLeadsAwaitingImport(LeadList $leadList, Carbon $startDay): LeadList {

    }

    public function attachLeadToList(LeadList $leadList, Lead $lead): Lead {

    }
}
