<?php

namespace App\Domain\Task\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $task_event_type_id
 * @property int $task_event_reason_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property TaskEventType $taskEventType
 * @property TaskEventReason $taskEventReason
 * @property User $user
 */
class TaskEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_event_type_id', 'task_event_reason_id', 'user_id',
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
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
