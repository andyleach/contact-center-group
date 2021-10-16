<?php

namespace App\Actions\Roster;

use App\Exceptions\Roster\RosterDoesNotExistException;
use App\Models\Agent\Agent;
use App\Models\Roster\Roster;

/**
 * Verifies that an agent is current scheduled to be working.
 */
class VerifyThatAgentIsCurrentlyScheduledForWork {
    /**
     * @param Agent $agent
     * @return bool
     *
     * @throws RosterDoesNotExistException
     */
    public function handle(Agent $agent): bool {
        $dateBeingVerified = now();
        $roster = Roster::where('date', $dateBeingVerified)->get();

        if (false == is_a($roster, Roster::class)) {
            throw new RosterDoesNotExistException('No roster found for date');
        }

        return $roster->agents()
            ->wherePivot('agent_id', $agent->id)
            ->wherePivot('hour', $dateBeingVerified->format('H'))
            ->exists();
    }
}
