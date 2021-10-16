<?php

namespace App\Models\Task;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Domain\Task\Models\TaskEventType
 *
 * @param int $id
 * @param string $label
 * @param Carbon $created_at
 * @param Carbon $updated_at
 * @param Collection|array<TaskEvent> $taskEvents
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task\TaskEvent[] $taskEvents
 * @property-read int|null $task_events_count
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventType whereDeletedAt($value)
 */
class TaskEventType extends Model
{
    use HasFactory;

    const TASK_ASSIGNED = 1;
    const TASK_ASSIGNMENT_CANCELLED = 2;
    const TASK_EXPIRED = 3;
    const TASK_REMOVED = 4;

    /**
     * @return HasMany
     */
    public function taskEvents(): HasMany {
        return $this->hasMany(TaskEvent::class, 'task_event_type_id');
    }
}
