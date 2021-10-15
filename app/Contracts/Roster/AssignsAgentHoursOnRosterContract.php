<?php


namespace App\Contracts\Roster;



use App\Models\Agent\Agent;
use App\Models\Roster\Roster;
use Illuminate\Support\Carbon;

/**
 * Responsible for assigning an agent hours on a roster
 */
interface AssignsAgentHoursOnRosterContract {
    /**
     * @param Agent $agent
     * @param Roster $roster
     * @param Carbon $startOfDay
     * @param Carbon $endOfDay
     * @return Roster
     */
    public function handle(Agent $agent, Roster $roster, Carbon $startOfDay, Carbon $endOfDay): Roster;
}
