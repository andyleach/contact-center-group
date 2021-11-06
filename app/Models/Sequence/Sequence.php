<?php

namespace App\Models\Sequence;

use App\Models\Lead\Lead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Sequence\Sequence
 *
 * @property int $id
 * @property string $label
 * @property string $description
 * @property mixed $actions
 * @property float $cost_per_lead_in_usd
 * @property int $client_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereCostPerLeadInUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $sequence_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereSequenceTypeId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Lead[] $leads
 * @property-read int|null $leads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sequence\SequenceAction[] $sequenceActions
 * @property-read int|null $sequence_actions_count
 * @method static \Database\Factories\Sequence\SequenceFactory factory(...$parameters)
 */
class Sequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'description', 'cost_per_lead_in_usd', 'client_id'
    ];

    public function leads(): BelongsToMany {
        return $this->belongsToMany(Lead::class);
    }

    /**
     * @return HasMany
     */
    public function sequenceActions(): HasMany {
        return $this->hasMany(SequenceAction::class, 'sequence_id');
    }
}
