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
 * @property int $id
 * @property int $sequence_id
 * @property int $task_type_id
 * @property string|null $scheduled_start_time The time we will create the task to be worked
 * @property int $delay_in_seconds The delay added to the scheduled start time.  If start time is null, it will be assumed to be the current time
 * @property string $instructions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction whereDelayInSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction whereScheduledStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction whereSequenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction whereTaskTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SequenceAction whereUpdatedAt($value)
 */
class SequenceAction extends Model
{
    use HasFactory;

    /**
     * @var string[] $fillable
     */
    protected $fillable = ['sequence_id', 'task_type_id', 'scheduled_start_time', 'delay_in_seconds'];

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
