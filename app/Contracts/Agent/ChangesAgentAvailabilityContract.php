<?php


namespace App\Contracts\Agent;


use App\Models\Agent\Agent;

/**
 *
 */
interface ChangesAgentAvailabilityContract {
    /**
     * @param Agent $user
     * @param int $availability_type_id
     * @return Agent
     */
    public function handle(Agent $user, int $availability_type_id): Agent;
}
