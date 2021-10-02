<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskEvent extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function taskEventType(): BelongsTo {
        return $this->belongsTo(TaskEventType::class, 'task_event_type_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskEventReason(): BelongsTo {
        return $this->belongsTo(TaskEventReason::class, 'task_event_reason_id');
    }
}
