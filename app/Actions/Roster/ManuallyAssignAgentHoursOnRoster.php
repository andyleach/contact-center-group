<?php

namespace App\Actions\Roster;

use App\Contracts\Roster\AssignsAgentHoursOnRosterContract;
use App\Contracts\Roster\RemovesHoursFromAgentOnRosterContract;
use App\Models\Agent\Agent;
use App\Models\Roster\Roster;
use Illuminate\Support\Carbon;

/**
 * Allows for an admin to manually assign an agent hours on a roster.
 * You will be allowed to swap out this strategy by creating a new class and swapping out the binding
 */
class ManuallyAssignAgentHoursOnRoster implements AssignsAgentHoursOnRosterContract {
    /**
     * @param Agent $agent
     * @param Roster $roster
     * @param Carbon $startOfDay
     * @param Carbon $endOfDay
     * @return Roster
     * @throws \Exception
     */
    public function handle(Agent $agent, Roster $roster, Carbon $startOfDay, Carbon $endOfDay): Roster {
        // Removes all hours for an agent on the roster
        $action = app(RemovesHoursFromAgentOnRosterContract::class);
        $action->handle($agent, $roster);

        $scheduledHour = $startOfDay->copy();

        for (;$scheduledHour->gte($endOfDay); $scheduledHour->addHour()) {
            $roster->agents()->save($agent, ['hour' => $scheduledHour->format('H')]);
        }

        return $roster;
    }
}
