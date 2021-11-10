<?php

namespace App\Models\Task;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Task\TaskOriginationType
 * 
 * This model is used to define how it was that our task came into existence.
 *
 * @property int $id
 * @property string $label
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskOriginationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskOriginationType extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'description'];

    const MATCHED_INBOUND_ACTIVITY = 1;
    const UNMATCHED_INBOUND_ACTIVITY = 2;
    const SEQUENCE = 3;
}
