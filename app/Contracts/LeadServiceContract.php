<?php


namespace App\Contracts;


use App\Http\DataTransferObjects\LeadData;
use App\Models\Lead\Lead;

interface LeadServiceContract {
    /**
     * @param LeadData $data
     * @return Lead
     */
    public function createLead(LeadData $data): Lead;
}
