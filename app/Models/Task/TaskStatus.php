<?php

namespace App\Models\Task;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Domain\Task\Models\TaskStatus
 *
 * @param int $id
 * @param string $label
 * @param string $description
 * @param bool   $is_expirable
 * @param Carbon $created_at
 * @param Carbon $updated_at
 * @param Collection|array<Task> $tasks
 * @property int $id
 * @property string $label
 * @property string $description
 * @property int $is_expirable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task\Task[] $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereIsExpirable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereDeletedAt($value)
 * @property int $is_removable
 * @property int $is_agent_dismissible
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereIsAgentDismissible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskStatus whereIsRemovable($value)
 */
class TaskStatus extends Model
{
    use HasFactory;

    const DRAFT = 1;
    const PENDING = 2;
    const ASSIGNED = 3;
    const IN_PROCESS = 4;
    const CLOSE_PENDING = 6;
    const CLOSED = 7;
    const CLOSE_FAILED = 8;
    const REMOVED = 9;
    const EXPIRED = 10;

    /**
     * @return HasMany
     */
    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'task_status_id');
    }
}
