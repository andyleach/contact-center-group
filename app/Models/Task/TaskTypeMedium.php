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
 * @param Collection|array<TaskType> $taskTypes
 */
class TaskTypeMedium extends Model
{
    use HasFactory;

    protected $table = 'task_type_mediums';

    const NOT_APPLICABLE = 1;
    CONST CALL = 2;
    CONST SMS = 3;
    CONST EMAIL = 4;

    /**
     * @return HasMany
     */
    public function taskTypes(): HasMany {
        return $this->hasMany(TaskType::class, 'task_type_medium_id');
    }
}
