<?php

namespace App\Models\Task;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @param int $id
 * @param string $label
 * @param Carbon $created_at
 * @param Carbon $updated_at
 *
 * @param Collection|array<TaskEvent> $taskEvents
 */
class TaskEventType extends Model
{
    use HasFactory;

    const TASK_ASSIGNED = 1;
    const TASK_ASSIGNMENT_CANCELLED = 2;
    const TASK_EXPIRED = 3;

    /**
     * @return HasMany
     */
    public function taskEvents(): HasMany {
        return $this->hasMany(TaskEvent::class, 'task_event_type_id');
    }
}
