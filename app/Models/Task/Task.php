<?php

namespace App\Models\Task;

use App\Events\Task\TaskCreated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property int $task_status_id
 * @property int $task_type_id
 * @property int $task_disposition_id

 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $user
 * @property TaskStatus $taskStatus
 * @property TaskType $taskType
 * @property Collection|array<TaskEvent> $taskEvent
 * @property TaskDisposition $taskDisposition
 */
class Task extends Model
{
    use HasFactory;

    /**
     * @var string[] $dispatchesEvents
     */
    protected $dispatchesEvents = [
        'created' => TaskCreated::class,
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskStatus(): BelongsTo {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskType(): BelongsTo {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskEvent(): BelongsTo {
        return $this->belongsTo(TaskEvent::class, 'task_event_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskDisposition(): BelongsTo {
        return $this->belongsTo(TaskDisposition::class, 'task_disposition_id');
    }
}
