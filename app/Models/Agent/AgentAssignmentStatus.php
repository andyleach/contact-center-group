<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Agent\AgentAssignmentStatus
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAssignmentStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAssignmentStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAssignmentStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAssignmentStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAssignmentStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAssignmentStatus whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AgentAssignmentStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AgentAssignmentStatus extends Model
{
    use HasFactory;

    const NO_TASK = 1;
    const LOOKING_FOR_TASK = 2;
    const ASSIGNED_TASK = 3;
    const WORKING_TASK = 4;
    const WRAPPING_UP_TASK = 5;
}
