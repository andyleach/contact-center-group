<?php

namespace App\Domain\Task\Models;

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
