<?php


namespace App\Contracts\Agent;



use App\Models\Agent\Agent;

/**
 * DisablesAgentContract
 */
interface DisablesAgentContract {
    /**
     * @param Agent $agent
     * @return Agent
     */
    public function handle(Agent $agent): Agent;
}
