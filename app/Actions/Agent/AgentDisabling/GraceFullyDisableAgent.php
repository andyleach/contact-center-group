<?php

namespace App\Actions\Agent\AgentDisabling;

use App\Contracts\Agent\DisablesAgentContract;
use App\Events\Agent\AgentDisabled;
use App\Models\Agent\Agent;

/**
 * GraceFullyDisableAgent
 *
 * Disables the agent and allows them to finish all open work, but will prevent them from being assigned anything new
 */
class GraceFullyDisableAgent implements DisablesAgentContract {
    /**
     * @param Agent $agent
     * @return Agent
     */
    public function handle(Agent $agent): Agent {
        // TODO: Implement handle() method.

        AgentDisabled::dispatch($agent);

        return $agent;
    }
}
