<?php

namespace App\Models\Customer;

use App\Services\DataTransferObjects\LeadData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Customer\CustomerPhoneNumber
 *
 * @property-read \App\Models\Customer\Customer $customer
 * @method static Builder|CustomerPhoneNumber matchToLeadData(\App\Services\DataTransferObjects\LeadData $leadData)
 * @method static Builder|CustomerPhoneNumber newModelQuery()
 * @method static Builder|CustomerPhoneNumber newQuery()
 * @method static Builder|CustomerPhoneNumber query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $phone_number
 * @property int $customer_id
 * @property string $last_seen_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Customer\CustomerPhoneNumberFactory factory(...$parameters)
 * @method static Builder|CustomerPhoneNumber whereCreatedAt($value)
 * @method static Builder|CustomerPhoneNumber whereCustomerId($value)
 * @method static Builder|CustomerPhoneNumber whereId($value)
 * @method static Builder|CustomerPhoneNumber whereLastSeenAt($value)
 * @method static Builder|CustomerPhoneNumber wherePhoneNumber($value)
 * @method static Builder|CustomerPhoneNumber whereUpdatedAt($value)
 * @method static Builder|CustomerPhoneNumber matchClientCustomerPhoneNumbers(int $client_id, array $phoneNumbers = [])
 * @method static Builder|CustomerPhoneNumber matchClientCustomerPhoneNumber(int $client_id, $phoneNumbers)
 */
class CustomerPhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number', 'customer_id', 'last_seen_at',
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function scopeMatchClientCustomerPhoneNumber(Builder $query, int $client_id, $phoneNumbers): Builder {
        if (is_array($phoneNumbers)) {
            $query->whereIn('phone_number', $phoneNumbers);
        } else {
            $query->where('phone_number', $phoneNumbers);
        }

        return $query->whereHas('customer', function($query) use ($client_id) {
            $query->where('client_id', $client_id);
        });
    }
}
