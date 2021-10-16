<?php


namespace App\Contracts\Agent;


use App\Models\Agent\Agent;

/**
 *
 */
interface ChangesAgentAvailabilityContract {
    /**
     * @param Agent $agent
     * @param int $availability_type_id
     * @return Agent
     */
    public function handle(Agent $agent, int $availability_type_id): Agent;
}
