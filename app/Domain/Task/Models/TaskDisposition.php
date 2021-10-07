<?php

namespace App\Domain\Task\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Domain\Task\Models\TaskDisposition
 *
 * @param int $id
 * @param string $label
 * @param Carbon $created_at
 * @param Carbon $updated_at
 * @param Collection|array<Task> $tasks
 * @property int $id
 * @property string $label
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDisposition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDisposition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDisposition query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDisposition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDisposition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDisposition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDisposition whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDisposition whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskDisposition extends Model
{
    use HasFactory;
}
