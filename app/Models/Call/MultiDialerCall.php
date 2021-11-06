<?php

namespace App\Models\Call;

use App\Models\Task\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A call classification where we will receive a new call on a purchased number and instead of answering it ourselves
 * we will route it to all of the designated contact numbers for that phone number.  The first one to accept the call
 * will get the call, and it will hang up on all remaining designated contact numbers.
 * 
 * If there is only one number to call, we will bypass the on hold phase for the caller and instead connect them directly
 * to the call
 *
 * @property int $id
 * @property int $client_phone_number_id
 * @property string $phone_number
 * @property int $provider_id
 * @property string $provider_sid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall query()
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall whereClientPhoneNumberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall whereProviderSid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MultiDialerCall whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MultiDialerCall extends Model
{
    use HasFactory;
}
