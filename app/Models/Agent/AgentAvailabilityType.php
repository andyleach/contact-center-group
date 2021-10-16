<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Agent\AgentAvailabilityType
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAvailabilityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAvailabilityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAvailabilityType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAvailabilityType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAvailabilityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAvailabilityType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAvailabilityType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $is_task_assignment_allowed
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAvailabilityType whereIsTaskAssignmentAllowed($value)
 */
class AgentAvailabilityType extends Model
{
    use HasFactory;

    const UNAVAILABLE = 1;
    const AVAILABLE = 2;
    const WINDING_DOWN = 3;
}
