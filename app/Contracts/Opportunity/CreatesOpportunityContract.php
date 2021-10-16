<?php


namespace App\Contracts\Opportunity;


use App\Models\Lead\Lead;
use App\Models\Opportunity\Opportunity;

interface CreatesOpportunityContract {
    public function handle(Lead $lead): Opportunity;
}
