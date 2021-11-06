<?php

namespace App\Models\Sequence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sequence\SequenceActionRestriction
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceActionRestriction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceActionRestriction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceActionRestriction query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $label
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceActionRestriction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceActionRestriction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceActionRestriction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceActionRestriction whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceActionRestriction whereUpdatedAt($value)
 * @method static \Database\Factories\Sequence\SequenceActionRestrictionFactory factory(...$parameters)
 */
class SequenceActionRestriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'description'
    ];
}
