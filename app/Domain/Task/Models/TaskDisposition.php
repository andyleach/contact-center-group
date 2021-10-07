<?php

namespace App\Domain\Task\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @param int $id
 * @param string $label
 * @param Carbon $created_at
 * @param Carbon $updated_at
 *
 * @param Collection|array<Task> $tasks
 */
class TaskDisposition extends Model
{
    use HasFactory;
}
