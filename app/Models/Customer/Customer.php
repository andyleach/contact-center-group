<?php

namespace App\Models\Customer;

use App\Models\Lead\Lead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Customer\Customer
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Lead[] $leads
 * @property-read int|null $leads_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerEmailAddress[] $customerEmailAddresses
 * @property-read int|null $customer_email_addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerPhoneNumber[] $customerPhoneNumbers
 * @property-read int|null $customer_phone_numbers_count
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property int $client_id
 * @method static \Database\Factories\Customer\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereLastName($value)
 */
class Customer extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function leads(): HasMany {
        return $this->hasMany(Lead::class, 'lead_id');
    }

    /**
     * @return HasMany
     */
    public function customerPhoneNumbers(): HasMany {
        return $this->hasMany(CustomerPhoneNumber::class, 'customer_id');
    }

    /**
     * @return HasMany
     */
    public function customerEmailAddresses(): HasMany {
        return $this->hasMany(CustomerEmailAddress::class, 'customer_id');
    }
}
