<?php

namespace App\Actions\Agent;

use App\Contracts\Agent\ChangesAgentAvailabilityContract;
use App\Events\Agent\AgentBeganWindingDown;
use App\Events\Agent\AgentWentAvailable;
use App\Events\Agent\AgentWentUnavailable;
use App\Models\Agent\Agent;
use App\Models\Agent\AgentAvailabilityType;

class ChangeAgentAvailability implements ChangesAgentAvailabilityContract {
    /**
     * @param Agent $agent
     * @param int $availability_type_id
     * @return Agent
     */
    public function handle(Agent $agent, int $availability_type_id): Agent {
        $agent->availability_type_id = $availability_type_id;
        $agent->save();

        if (AgentAvailabilityType::UNAVAILABLE === $availability_type_id) {
            AgentWentUnavailable::dispatch($agent);
        } else if (AgentAvailabilityType::AVAILABLE === $availability_type_id) {
            AgentWentAvailable::dispatch($agent);
        } else if (AgentAvailabilityType::WINDING_DOWN === $availability_type_id) {
            AgentBeganWindingDown::dispatch($agent);
        }

        return $agent;
    }
}
