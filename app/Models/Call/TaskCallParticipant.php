<?php

namespace App\Models\Call;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Call\TaskCallParticipant
 *
 * @property int $id
 * @property int $task_call_id
 * @property string $label
 * @property int|null $agent_id
 * @property string $joined_at
 * @property string $exited_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereExitedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereTaskCallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $task_call_participant_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipant whereTaskCallParticipantTypeId($value)
 */
class TaskCallParticipant extends Model
{
    use HasFactory;
}
