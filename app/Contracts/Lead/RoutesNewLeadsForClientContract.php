<?php


namespace App\Contracts\Lead;


use App\Models\Lead\Lead;

interface RoutesNewLeadsForClientContract {
    /**
     * @param Lead $lead
     * @return Lead
     */
    public function handle(Lead $lead): Lead;
}
