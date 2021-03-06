<?php

namespace App\Models\Task;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Domain\Task\Models\TaskType
 *
 * @param int $id
 * @param string $label
 * @param Carbon $created_at
 * @param Carbon $updated_at
 * @param Collection|array<Task> $tasks
 * @property int $id
 * @property string $label
 * @property string $description
 * @property int $task_type_medium_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task\Task[] $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereTaskTypeMediumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereDeletedAt($value)
 * @property string|null $begin_assignment_at The beginning of the window in which we will allow a task of this type to be assigned
 * @property string|null $end_assignment_at The end of the window in which we will allow a task of the type to be assigned.
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereBeginAssignmentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskType whereEndAssignmentAt($value)
 */
class TaskType extends Model
{
    use HasFactory;

    const INBOUND_CALL = 1;
    const OUTBOUND_CALL = 2;
    const MISSED_CALL_CALLBACK = 3;
    const NON_WORKING_HOURS_CALLBACK = 4;
    const INBOUND_SMS = 5;
    const OUTBOUND_SMS = 6;
    const INBOUND_EMAIL = 7;
    const OUTBOUND_EMAIL = 8;

    const ALL_TYPES = [
        self::INBOUND_CALL,
        self::OUTBOUND_CALL,
        self::MISSED_CALL_CALLBACK,
        self::NON_WORKING_HOURS_CALLBACK,
        self::INBOUND_SMS,
        self::OUTBOUND_SMS,
        self::INBOUND_EMAIL,
        self::OUTBOUND_EMAIL,
    ];

    /**
     * @return HasMany
     */
    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'task_type_id');
    }
}
