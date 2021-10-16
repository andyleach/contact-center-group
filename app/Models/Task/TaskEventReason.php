<?php

namespace App\Models\Task;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Domain\Task\Models\TaskEventReason
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
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventReason whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventReason whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskEventReason whereDeletedAt($value)
 */
class TaskEventReason extends Model
{
    use HasFactory;

    const NOT_APPLICABLE = 1;

    /**
     * @return HasMany
     */
    public function taskEvents(): HasMany {
        return $this->hasMany(TaskEvent::class, 'task_event_reason_id');
    }
}
