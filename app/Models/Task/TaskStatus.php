<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskStatus extends Model
{
    use HasFactory;

    const DRAFT = 1;
    const PENDING = 2;
    const ASSIGNED = 3;
    const IN_PROCESS = 4;
    const WRAPPING_UP = 5;
    const CLOSE_PENDING = 6;
    const CLOSED = 7;
    const CLOSE_FAILED = 8;
    const REMOVED = 9;

    /**
     * @return HasMany
     */
    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'task_status_id');
    }
}
