<?php

namespace App\Actions\Agent\AgentAvailability;

use App\Contracts\Agent\ChangesAgentAvailabilityContract;
use App\Events\Agent\AgentBeganWindingDown;
use App\Models\Agent\Agent;

class MarkAgentAsWindingDown implements ChangesAgentAvailabilityContract {
    /**
     * @inheritDoc
     */
    public function handle(Agent $agent, int $availability_type_id): Agent {
        $agent->availability_type_id = $availability_type_id;
        $agent->save();

        AgentBeganWindingDown::dispatch($agent);

        return $agent;
    }
}
