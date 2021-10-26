<?php

namespace App\Models\Lead;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Lead\LeadPhoneNumber
 *
 * @property int $id
 * @property string $phone_number
 * @property int $is_valid
 * @property int $lead_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber whereIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadPhoneNumber whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Lead\Lead $lead
 * @method static \Database\Factories\Lead\LeadPhoneNumberFactory factory(...$parameters)
 */
class LeadPhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number', 'lead_id', 'is_valid'
    ];

    public function lead(): BelongsTo {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
