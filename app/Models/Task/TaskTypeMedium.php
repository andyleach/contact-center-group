<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskTypeMedium extends Model
{
    use HasFactory;

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
