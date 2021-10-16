<?php

namespace App\Contracts\Lead;

use App\Actions\Lead\DataTransferObjects\LeadData;
use App\Models\Lead\Lead;

interface CreatesNewLeadContract {
    /**
     * @param LeadData $data
     * @return Lead
     */
    public function handle(LeadData $data): Lead;
}
