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
 * @param Collection|array<Task> $tasks
 */
class TaskType extends Model
{
    use HasFactory;

    const INBOUND_CALL = 1;
    const OUTBOUND_CALL = 2;
    const MISSED_CALL_CALLBACK = 3;
    const NON_WORKING_HOURS_CALLBACK = 4;

    /**
     * @return HasMany
     */
    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'task_type_id');
    }
}
