<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User\UserAvailabilityType
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAvailabilityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAvailabilityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAvailabilityType query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAvailabilityType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAvailabilityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAvailabilityType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAvailabilityType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserAvailabilityType extends Model
{
    use HasFactory;

    protected $fillable = ['label'];

    const UNAVAILABLE = 1;
    const AVAILABLE = 2;
    const WINDING_DOWN = 3;
}
