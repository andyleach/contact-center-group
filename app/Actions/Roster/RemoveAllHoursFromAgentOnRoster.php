<?php

namespace App\Actions\Roster;

use App\Contracts\Roster\RemovesHoursFromAgentOnRosterContract;
use App\Models\Agent\Agent;
use App\Models\Roster\Roster;

/**
 * Removes all hours from a roster for an agent
 */
class RemoveAllHoursFromAgentOnRoster implements RemovesHoursFromAgentOnRosterContract {
    /**
     * @param Agent $agent
     * @param Roster $roster
     * @return Roster
     */
    public function handle(Agent $agent, Roster $roster): Roster {
        // Clears agent schedule for day
        $roster->agents()
            ->wherePivot('agent_id', '=', $agent->id)
            ->sync([]);

        return $roster;
    }
}
