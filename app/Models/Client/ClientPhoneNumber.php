<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Client\ClientPhoneNumber
 *
 * @property int $id
 * @property int $client_id
 * @property string $phone_number
 * @property string $forward_number
 * @property string $call_handling
 * @property string $provider_sid The unique identifier provider to this resource by a provider
 * @property int $provider_id
 * @property string $purchased_at
 * @property string $expires_at Used to indicate a future date in which we will stop servicing a phone number
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereCallHandling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereForwardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereProviderSid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber wherePurchasedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumber whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClientPhoneNumber extends Model
{
    use HasFactory;

    const ROUTE_TO_AGENT = 'Route To Agent';
    const MULTI_DIALER = 'Multi-Dialer';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'client_id', 'phone_number', 'forward_number', 'call_handling', 'provider_sid', 'provider_id',
        'purchased_at', 'expires_at'
    ];
}
