<?php

namespace App\Models\Task;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Domain\Task\Models\TaskTypeMedium
 *
 * @param int $id
 * @param string $label
 * @param Carbon $created_at
 * @param Carbon $updated_at
 * @param Collection|array<TaskType> $taskTypes
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task\TaskType[] $taskTypes
 * @property-read int|null $task_types_count
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTypeMedium newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTypeMedium newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTypeMedium query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTypeMedium whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTypeMedium whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTypeMedium whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTypeMedium whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskTypeMedium whereDeletedAt($value)
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
