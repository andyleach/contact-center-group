<?php

namespace App\Actions\Agent\AgentDisabling;

use App\Contracts\Agent\DisablesAgentContract;
use App\Events\Agent\AgentDisabled;
use App\Models\Agent\Agent;

/**
 * EmergencyDisablingOfAgent
 *
 * Disables an agent, and locks down all forms of access. This includes:
 *
 * - Terminating all forms of active communication (Calls, Sms, Email, Live Chat)
 * - Disabling the agent to prevent future work
 * - Disabling the login to prevent any further access to the application
 * - Rescheduling the task that was being worked on
 */
class EmergencyDisablingOfAgent implements DisablesAgentContract {
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
