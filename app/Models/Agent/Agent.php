<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class Agent extends Model
{
    use HasFactory;
}
