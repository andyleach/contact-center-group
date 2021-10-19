<?php

namespace App\Http\Services;

use App\Contracts\AgentServiceContract;
use App\Events\Agent\AgentBeganWindingDown;
use App\Events\Agent\AgentDisabled;
use App\Events\Agent\AgentWentAvailable;
use App\Events\Agent\AgentWentUnavailable;
use App\Exceptions\Agent\AgentNotScheduledForWorkException;
use App\Exceptions\Roster\RosterDoesNotExistException;
use App\Models\Agent\Agent;
use App\Models\Agent\AgentAvailabilityType;
use App\Models\Roster\Roster;

class AgentService implements AgentServiceContract {

    /**
     * @param Agent $agent
     * @return bool
     * @throws RosterDoesNotExistException
     */
    public function isAgentCurrentlyScheduledToWork(Agent $agent): bool {
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

    /**
     * @param Agent $agent
     * @return Agent
     * @throws AgentNotScheduledForWorkException
     * @throws RosterDoesNotExistException
     */
    public function markAgentAsAvailable(Agent $agent): Agent {
        $isAgentScheduledForWork = $this->isAgentCurrentlyScheduledToWork($agent);
        if (false == $isAgentScheduledForWork) {
            throw new AgentNotScheduledForWorkException('Agent is not scheduled for work');
        }

        $agent->availability_type_id = AgentAvailabilityType::AVAILABLE;
        $agent->save();

        AgentWentAvailable::dispatch($agent);

        return $agent;
    }

    /**
     * @inheritDoc
     */
    public function markAgentAsUnavailable(Agent $agent): Agent {
        $agent->availability_type_id = AgentAvailabilityType::UNAVAILABLE;
        $agent->save();

        AgentWentUnavailable::dispatch($agent);

        return $agent;
    }

    /**
     * @param Agent $agent
     * @return Agent
     */
    public function markAgentAsWindingDown(Agent $agent): Agent {
        $agent->availability_type_id = AgentAvailabilityType::WINDING_DOWN;
        $agent->save();

        AgentBeganWindingDown::dispatch($agent);

        return $agent;
    }

    /**
     * Disables an agent, and locks down all forms of access. This includes:
     *
     * - Terminating all forms of active communication (Calls, Sms, Email, Live Chat)
     * - Disabling the agent to prevent future work
     * - Disabling the login to prevent any further access to the application
     * - Rescheduling the task that was being worked on
     *
     * @param Agent $agent
     * @return Agent
     */
    public function emergencyDisableAgent(Agent $agent): Agent {
        $agent->disabled_at = now();
        $agent->save();

        AgentDisabled::dispatch($agent);

        return $agent;
    }

    /**
     *
     * Disables the agent and allows them to finish all open work, but will prevent them from being assigned anything new
     *
     * @param Agent $agent
     * @return Agent
     */
    public function gracefullyDisableAgent(Agent $agent): Agent {
        $agent->disabled_at = now();
        $agent->save();

        AgentDisabled::dispatch($agent);

        return $agent;
    }
}
