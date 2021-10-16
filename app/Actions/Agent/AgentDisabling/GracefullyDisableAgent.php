<?php

namespace App\Actions\Agent\AgentDisabling;

use App\Contracts\Agent\DisablesAgentContract;
use App\Events\Agent\AgentDisabled;
use App\Models\Agent\Agent;

/**
 * GracefullyDisableAgent
 *
 * Disables the agent and allows them to finish all open work, but will prevent them from being assigned anything new
 */
class GracefullyDisableAgent implements DisablesAgentContract {
    /**
     * @param Agent $agent
     * @return Agent
     */
    public function handle(Agent $agent): Agent {
        $agent->disabled_at = now();
        $agent->save();

        AgentDisabled::dispatch($agent);

        return $agent;
    }
}
