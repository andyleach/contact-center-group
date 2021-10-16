<?php

namespace App\Actions\Lead\Routing;

use App\Contracts\Lead\RoutesNewLeadsForClientContract;
use App\Models\Lead\Lead;

/**
 * Takes the lead, and using the lead type assigns the correct sequence so tasks may be created for agents
 */
class RouteLeadByType implements RoutesNewLeadsForClientContract {

    /**
     * @inheritDoc
     */
    public function handle(Lead $lead): Lead {
        // TODO: Implement handle() method.

        return $lead;
    }
}
