<?php

namespace App\Models\Task;

use App\Events\Task\TaskCreated;
use App\Models\Agent\Agent;
use App\Models\Call\TaskCall;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @property int|null $agent_id
 * @property-read Agent|null $agent
 * @method static \Database\Factories\Task\TaskFactory factory(...$parameters)
 * @method static Builder|Task whereAgentId($value)
 * @property int|null $sequence_id
 * @property string|null $sequence_action_identifier
 * @property-read \App\Models\Task\TaskDetail|null $taskDetails
 * @method static Builder|Task whereSequenceActionIdentifier($value)
 * @method static Builder|Task whereSequenceId($value)
 * @property int $is_first_contact
 * @property int $is_followup
 * @property int $is_client_requested
 * @property string|null $completed_at
 * @method static Builder|Task whereCompletedAt($value)
 * @method static Builder|Task whereIsClientRequested($value)
 * @method static Builder|Task whereIsFirstContact($value)
 * @method static Builder|Task whereIsFollowup($value)
 * @property int $lead_id
 * @property int|null $sequence_action_id Used to identify the sequence action that prompted the creation of the task
 * @method static Builder|Task whereLeadId($value)
 * @method static Builder|Task whereSequenceActionId($value)
 * @property string $instructions
 * @method static Builder|Task whereInstructions($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|TaskCall[] $taskCall
 * @property-read int|null $task_call_count
 * @property int $task_origination_type_id
 * @property-read \App\Models\Task\TaskOriginationType $taskOriginationType
 * @method static Builder|Task whereTaskOriginationTypeId($value)
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

    protected $dates = [
        'available_at', 'expires_at', 'completed_at', 'assigned_at'
    ];

    protected $fillable = [
        'sequence_action_id', 'agent_id', 'task_status_id', 'task_type_id', 'lead_id',
        'task_disposition_id', 'instructions', 'available_at', 'expires_at', 'completed_at', 'assigned_at',
        'task_origination_type_id',
    ];

    /**
     * @return BelongsTo
     */
    public function agent(): BelongsTo {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /**
     * @return HasOne
     */
    public function taskDetails(): HasOne {
        return $this->hasOne(TaskDetail::class, 'task_id');
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
     * @return BelongsTo
     */
    public function taskOriginationType(): BelongsTo {
        return $this->belongsTo(TaskOriginationType::class, 'task_origination_type_id');
    }

    /**
     * @return HasMany
     */
    public function taskCall(): HasMany {
        return $this->hasMany(TaskCall::class, 'task_id');
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
