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
