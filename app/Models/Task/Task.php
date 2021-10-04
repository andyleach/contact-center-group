<?php

namespace App\Models\Task;

use App\Events\Task\TaskCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * @var string[] $dispatchesEvents
     */
    protected $dispatchesEvents = [
        'created' => TaskCreated::class,
    ];

    /**
     * @return BelongsTo
     */
    public function taskStatus(): BelongsTo {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskType(): BelongsTo {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskEvent(): BelongsTo {
        return $this->belongsTo(TaskEvent::class, 'task_event_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskDisposition(): BelongsTo {
        return $this->belongsTo(TaskDisposition::class, 'task_disposition_id');
    }
}
