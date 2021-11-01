<?php

namespace App\Models\Sequence;

use App\Models\Task\TaskType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Sequence\SequenceAction
 *
 * @property int $id
 * @property int $sequence_id
 * @property int $task_type_id
 * @property string|null $scheduled_start_time The time we will create the task to be worked
 * @property int $delay_in_seconds The delay added to the scheduled start time.  If start time is null, it will be assumed to be the current time
 * @property string $instructions
 * @property int $ordinal_position Used to represent the positional order of an action in a sequence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sequence\SequenceActionRestriction[] $sequenceActionRestrictions
 * @property-read int|null $sequence_action_restrictions_count
 * @method static Builder|SequenceAction afterSequencePosition(int $sequence_id, int $ordinal_position)
 * @method static Builder|SequenceAction newModelQuery()
 * @method static Builder|SequenceAction newQuery()
 * @method static Builder|SequenceAction query()
 * @method static Builder|SequenceAction whereCreatedAt($value)
 * @method static Builder|SequenceAction whereDelayInSeconds($value)
 * @method static Builder|SequenceAction whereId($value)
 * @method static Builder|SequenceAction whereInstructions($value)
 * @method static Builder|SequenceAction whereOrdinalPosition($value)
 * @method static Builder|SequenceAction whereScheduledStartTime($value)
 * @method static Builder|SequenceAction whereSequenceId($value)
 * @method static Builder|SequenceAction whereTaskTypeId($value)
 * @method static Builder|SequenceAction whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Sequence\Sequence $sequence
 * @property-read TaskType $taskType
 */
class SequenceAction extends Model
{
    use HasFactory;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'sequence_id', 'task_type_id', 'scheduled_start_time', 'delay_in_seconds', 'instructions', 'ordinal_position'
    ];

    public function sequence(): BelongsTo {
        return $this->belongsTo(Sequence::class, 'sequence_id');
    }

    public function taskType(): BelongsTo {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }

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

    /**
     * @param Builder $query
     * @param int $sequence_id
     * @param int $ordinal_position
     * @return Builder
     */
    public function scopeAfterSequencePosition(Builder $query, int $sequence_id, int $ordinal_position): Builder {
        return $query->where('sequence_id', $sequence_id)
            ->where('ordinal_position', '>', $ordinal_position);
    }
}
