<?php

namespace App\Models\Task;

use App\Models\Agent\Agent;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Domain\Task\Models\TaskEvent
 *
 * @property int $id
 * @property int $task_event_type_id
 * @property int $task_event_reason_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property TaskEventType $taskEventType
 * @property TaskEventReason $taskEventReason
 * @property User $user
 * @property int $task_id
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent whereTaskEventReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent whereTaskEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $agent_id
 * @property-read Agent|null $agent
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEvent whereAgentId($value)
 */
class TaskEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_event_type_id', 'task_event_reason_id', 'agent_id',
    ];

    /**
     * @return BelongsTo
     */
    public function taskEventType(): BelongsTo {
        return $this->belongsTo(TaskEventType::class, 'task_event_type_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskEventReason(): BelongsTo {
        return $this->belongsTo(TaskEventReason::class, 'task_event_reason_id');
    }

    /**
     * @return BelongsTo
     */
    public function agent(): BelongsTo {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
