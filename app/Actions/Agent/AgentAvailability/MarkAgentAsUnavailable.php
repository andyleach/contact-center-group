<?php

namespace App\Actions\Agent\AgentAvailability;

use App\Contracts\Agent\ChangesAgentAvailabilityContract;
use App\Events\Agent\AgentWentUnavailable;
use App\Models\Agent\Agent;

class MarkAgentAsUnavailable implements ChangesAgentAvailabilityContract {
    /**
     * @inheritDoc
     */
    public function handle(Agent $agent, int $availability_type_id): Agent {
        $agent->availability_type_id = $availability_type_id;
        $agent->save();

        AgentWentUnavailable::dispatch($agent);

        return $agent;
    }
}
