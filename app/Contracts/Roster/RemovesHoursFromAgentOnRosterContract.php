<?php


namespace App\Contracts\Roster;



use App\Models\Agent\Agent;
use App\Models\Roster\Roster;

/**
 * Responsible for assigning an agent hours on a roster
 */
interface RemovesHoursFromAgentOnRosterContract {
    /**
     * @param Agent $agent
     * @param Roster $roster
     * @return Roster
     */
    public function handle(Agent $agent, Roster $roster): Roster;
}
