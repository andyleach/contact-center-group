<?php

namespace App\Models\Task;

use App\Domain\Task\Events\TaskCreated;
use App\Models\Agent\Agent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Domain\Task\Models\Task
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_status_id
 * @property int $task_type_id
 * @property int $task_disposition_id
 * @property Carbon $assigned_at
 * @property Carbon $expires_at
 * @property Carbon $closed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property TaskStatus $taskStatus
 * @property TaskType $taskType
 * @property Collection|array<TaskEvent> $taskEvents
 * @property TaskDisposition $taskDisposition
 * @property-read int|null $task_events_count
 * @method static Builder|Task assignable()
 * @method static Builder|Task expirable()
 * @method static Builder|Task newModelQuery()
 * @method static Builder|Task newQuery()
 * @method static Builder|Task query()
 * @method static Builder|Task whereAssignedAt($value)
 * @method static Builder|Task whereClosedAt($value)
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereExpiresAt($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereTaskDispositionId($value)
 * @method static Builder|Task whereTaskStatusId($value)
 * @method static Builder|Task whereTaskTypeId($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @method static Builder|Task whereUserId($value)
 * @mixin \Eloquent
 * @property array $unstructured_data
 * @property string $available_at
 * @method static Builder|Task whereAvailableAt($value)
 * @method static Builder|Task whereUnstructuredData($value)
 */
class Task extends Model
{
    use HasFactory;

    /**
     * @var string[] $dispatchesEvents
     */
    protected $dispatchesEvents = [
        'created' => TaskCreated::class,
    ];

    protected $casts = [
        'unstructured_data' => 'json'
    ];

    protected $fillable = ['agent_id', 'task_status_id', 'task_type_id', 'task_disposition_id'];

    /**
     * @return BelongsTo
     */
    public function agent(): BelongsTo {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

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
     * @return HasMany
     */
    public function taskEvents(): HasMany {
        return $this->hasMany(TaskEvent::class, 'task_id');
    }

    /**
     * @return BelongsTo
     */
    public function taskDisposition(): BelongsTo {
        return $this->belongsTo(TaskDisposition::class, 'task_disposition_id');
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeAssignable(Builder $query): Builder {
        return $query->where('task_status_id', TaskStatus::PENDING)
            ->where('available_at', '>=', now())
            ->where(function($query) {
                $query->where('expires_at', '>=', now())
                    ->orWhereNull('expires_at');
            });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeExpirable(Builder $query): Builder {
        return $query->whereHas('taskStatus', function($query) {
                $query->where('is_expirable', true);
            })->where('expires_at', '<=', now());
    }
}
