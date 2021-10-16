<?php

namespace App\Actions\Agent\AgentAvailability;

use App\Actions\Roster\VerifyThatAgentIsCurrentlyScheduledForWork;
use App\Contracts\Agent\ChangesAgentAvailabilityContract;
use App\Events\Agent\AgentWentAvailable;
use App\Exceptions\Agent\AgentNotScheduledForWorkException;
use App\Exceptions\Roster\RosterDoesNotExistException;
use App\Models\Agent\Agent;

class MarkAgentAsAvailable  implements ChangesAgentAvailabilityContract {
    /**
     * @inheritDoc
     * @throws AgentNotScheduledForWorkException
     * @throws RosterDoesNotExistException
     */
    public function handle(Agent $agent, int $availability_type_id): Agent {
        $isAgentScheduledForWork = app(VerifyThatAgentIsCurrentlyScheduledForWork::class)->handle($agent);
        if (false == $isAgentScheduledForWork) {
            throw new AgentNotScheduledForWorkException('Agent is not scheduled for work');
        }

        $agent->availability_type_id = $availability_type_id;
        $agent->save();

        AgentWentAvailable::dispatch($agent);

        return $agent;
    }
}
