<?php

namespace App\Http\Services;

use App\Contracts\Roster\AssignsAgentHoursOnRosterContract;
use App\Contracts\Roster\RemovesHoursFromAgentOnRosterContract;
use App\Models\Agent\Agent;
use App\Models\Roster\Roster;
use Illuminate\Support\Carbon;

class RosterService {
    public function createRoster() {

    }

    /**
     * @param Agent $agent
     * @param Roster $roster
     * @param Carbon $startOfDay
     * @param Carbon $endOfDay
     * @return Roster
     * @throws \Exception
     */
    public function manuallyAssignAgentHours(Agent $agent, Roster $roster, Carbon $startOfDay, Carbon $endOfDay): Roster {
        // Removes all hours for an agent on the roster
        $action = app(RemovesHoursFromAgentOnRosterContract::class);
        $action->handle($agent, $roster);

        $scheduledHour = $startOfDay->copy();

        for (;$scheduledHour->gte($endOfDay); $scheduledHour->addHour()) {
            $roster->agents()->save($agent, ['hour' => $scheduledHour->format('H')]);
        }

        return $roster;
    }

    public function addAgentToRoster() {
        app(AssignsAgentHoursOnRosterContract::class);
    }

    /**
     * @param Agent $agent
     * @param Roster $roster
     * @return Roster
     */
    public function removeAgentFromRoster(Agent $agent, Roster $roster): Roster {
            // Clears agent schedule for day
            $roster->agents()
                ->wherePivot('agent_id', '=', $agent->id)
                ->sync([]);

            return $roster;
    }
}
