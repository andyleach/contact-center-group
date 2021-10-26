<?php

namespace App\Models\Customer;

use App\Models\Lead\LeadEmailAddress;
use App\Models\Lead\LeadPhoneNumber;
use App\Services\DataTransferObjects\LeadData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Customer\CustomerEmailAddress
 *
 * @property-read \App\Models\Customer\Customer $customer
 * @method static Builder|CustomerEmailAddress matchToLeadData(\App\Services\DataTransferObjects\LeadData $leadData)
 * @method static Builder|CustomerEmailAddress newModelQuery()
 * @method static Builder|CustomerEmailAddress newQuery()
 * @method static Builder|CustomerEmailAddress query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $email_address
 * @property int $customer_id
 * @property string $last_seen_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Customer\CustomerEmailAddressFactory factory(...$parameters)
 * @method static Builder|CustomerEmailAddress whereCreatedAt($value)
 * @method static Builder|CustomerEmailAddress whereCustomerId($value)
 * @method static Builder|CustomerEmailAddress whereEmailAddress($value)
 * @method static Builder|CustomerEmailAddress whereId($value)
 * @method static Builder|CustomerEmailAddress whereLastSeenAt($value)
 * @method static Builder|CustomerEmailAddress whereUpdatedAt($value)
 * @method static Builder|CustomerEmailAddress matchClientCustomerEmailAddresses(int $client_id, array $emailAddresses = [])
 * @method static Builder|CustomerEmailAddress matchClientCustomerEmailAddress(int $client_id, $emailAddresses)
 * @property-read LeadEmailAddress $leadEmailAddress
 */
class CustomerEmailAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_address', 'customer_id', 'last_seen_at',
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Identifies the lead that we first saw this email_address on
     *
     * @return BelongsTo
     */
    public function leadEmailAddress(): BelongsTo {
        return $this->belongsTo(LeadEmailAddress::class, 'lead_id');
    }

    public function scopeMatchClientCustomerEmailAddress(Builder $query, int $client_id, $emailAddresses): Builder {
        if (is_array($emailAddresses)) {
            $query->whereIn('email_address', $emailAddresses);
        } else {
            $query->where('email_address', $emailAddresses);
        }

        return $query->whereHas('customer', function($query) use ($client_id) {
            $query->where('client_id', $client_id);
        });
    }
}
