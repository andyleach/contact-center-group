<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Agent\Agent
 *
 * @property int $id
 * @property int $user_id
 * @property int $availability_type_id
 * @property string $name
 * @property string|null $last_task_assigned_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Agent\AgentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereAvailabilityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereLastTaskAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $disabled_at
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereDisabledAt($value)
 * @property int $agent_assignment_status_id
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereAgentAssignmentStatusId($value)
 * @property-read \App\Models\Agent\AgentAssignmentStatus $agentAssignmentStatus
 * @property-read \App\Models\Agent\AgentAvailabilityType $agentAvailabilityType
 */
class Agent extends Model
{
    use HasFactory;

    /**
     * Indicates the agents overall availability in the system.  This includes things like whether they are:
     *
     * - Available for work
     * - Winding down
     * - Unavailable
     * @return BelongsTo
     */
    public function agentAvailabilityType(): BelongsTo {
        return $this->belongsTo(AgentAvailabilityType::class, 'agent_availability_type_id');
    }

    /**
     * Indicates the agent's current task assignment status.  This includes things like:
     *
     * - Having no task
     * - Looking for a task
     * - If they were just assigned a task
     * - If they are working on that task
     * - If they are wrapping up a task
     *
     * @return BelongsTo
     */
    public function agentAssignmentStatus(): BelongsTo {
        return $this->belongsTo(AgentAssignmentStatus::class, 'agent_assignment_status_id');
    }
}
