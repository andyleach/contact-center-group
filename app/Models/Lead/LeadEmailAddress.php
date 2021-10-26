<?php

namespace App\Models\Lead;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Lead\LeadEmailAddress
 *
 * @property int $id
 * @property string $email_address
 * @property int $is_valid
 * @property int $lead_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress whereIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadEmailAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Lead\Lead $lead
 * @method static \Database\Factories\Lead\LeadEmailAddressFactory factory(...$parameters)
 */
class LeadEmailAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_address', 'lead_id', 'is_valid'
    ];

    public function lead(): BelongsTo {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
