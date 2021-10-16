<?php

namespace App\Http\Services;

use App\Contracts\Roster\AssignsAgentHoursOnRosterContract;
use App\Contracts\Roster\RemovesHoursFromAgentOnRosterContract;

class RosterService {
    public function createRoster() {

    }

    public function addAgentToRoster() {
        app(AssignsAgentHoursOnRosterContract::class);
    }

    public function removeAgentFromRoster() {
        app(RemovesHoursFromAgentOnRosterContract::class);
    }
}
