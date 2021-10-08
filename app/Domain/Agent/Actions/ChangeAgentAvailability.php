<?php

namespace App\Domain\Agent\Actions;

use App\Domain\Agent\Contacts\ChangesAgentAvailabilityContract;
use App\Domain\Agent\Events\AgentBeganWindingDown;
use App\Domain\Agent\Events\AgentWentAvailable;
use App\Domain\Agent\Events\AgentWentUnavailable;
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
