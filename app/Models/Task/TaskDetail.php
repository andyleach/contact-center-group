<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Task\TaskDetail
 *
 * @property int $id
 * @property int $task_id
 * @property string $customer_number
 * @property string $customer_email
 * @property mixed $unstructured_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail whereCustomerNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail whereUnstructuredData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $instructions
 * @method static \Illuminate\Database\Eloquent\Builder|TaskDetail whereInstructions($value)
 */
class TaskDetail extends Model
{
    use HasFactory;
}
