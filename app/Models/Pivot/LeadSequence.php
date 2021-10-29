<?php

namespace App\Models\Pivot;

use App\Models\Lead\Lead;
use App\Models\Sequence\Sequence;
use App\Models\Sequence\SequenceAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Pivot\LeadSequence
 *
 * @property int $id
 * @property int $lead_id
 * @property int $sequence_id
 * @property int|null $sequence_action_id Used to identify the last sequence action that was created for a lead
 * @property string $assigned_at Indicates when we first assigned the sequence to the lead
 * @property string $closed_at Indicates that we have done all work we intend to do for this sequence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence whereAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence whereSequenceActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence whereSequenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadSequence whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Lead $lead
 * @property-read Sequence $sequence
 * @property-read SequenceAction|null $sequenceAction
 * @method static Builder|LeadSequence isClosed()
 * @method static Builder|LeadSequence isNotClosed()
 */
class LeadSequence extends Pivot
{
    use HasFactory;

    public function lead(): BelongsTo {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function sequence(): BelongsTo {
        return $this->belongsTo(Sequence::class, 'sequence_id');
    }

    /**
     * The last sequence action that was created
     *
     * @return BelongsTo
     */
    public function sequenceAction(): BelongsTo {
        return $this->belongsTo(SequenceAction::class, 'sequence_action_id');
    }

    public function scopeIsClosed(Builder $query): Builder {
        return $query->whereNotNull('closed_at');
    }

    public function scopeIsNotClosed(Builder $query): Builder {
        return $query->whereNull('closed_at');
    }
}
