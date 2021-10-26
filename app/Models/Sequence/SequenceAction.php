<?php

namespace App\Models\Sequence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Sequence\SequenceAction
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sequence\SequenceActionRestriction[] $sequenceActionRestrictions
 * @property-read int|null $sequence_action_restrictions_count
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction query()
 * @mixin \Eloquent
 */
class SequenceAction extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany
     */
    public function sequenceActionRestrictions(): BelongsToMany {
        return $this->belongsToMany(SequenceActionRestriction::class,
            'sequence_action_sequence_restriction',
            'sequence_action_id',
            'sequence_action_restriction_id'
        );
    }
}
