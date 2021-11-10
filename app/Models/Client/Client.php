<?php

namespace App\Models\Client;

use App\Events\Client\ClientCreated;
use App\Models\Lead\Lead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Client\Client
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Lead[] $leads
 * @property-read int|null $leads_count
 * @property string $label
 * @method static \Database\Factories\Client\ClientFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLabel($value)
 * @property string|null $twilio_account_sid
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereTwilioAccountSid($value)
 * @property string $twilio_sid A unique identifier for the sub-account that was created for this client in Twilio
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereTwilioSid($value)
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'label'
    ];

    protected $hidden = [
        'twilio_sid'
    ];

    protected $dispatchesEvents = [
        'created' => ClientCreated::class
    ];

    /**
     * @return HasMany
     */
    public function leads(): HasMany {
        return $this->hasMany(Lead::class, 'client_id');
    }
}
