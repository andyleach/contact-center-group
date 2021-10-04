<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskEventType extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function taskEvents(): HasMany {
        return $this->hasMany(TaskEvent::class, 'task_event_type_id');
    }
}