<?php

namespace App\Models\Lead;

use App\Events\Lead\LeadCreated;
use App\Models\Client\Client;
use App\Models\Customer\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Lead\Lead
 *
 * @property int $id
 * @property int $lead_status_id
 * @property int $lead_disposition_id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLeadDispositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLeadStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $client_id
 * @property int $lead_type_id
 * @property int $sequence_id
 * @property string $last_sequence_action_identifier
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLastSequenceActionIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLeadTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereSequenceId($value)
 * @property-read Client $client
 * @property-read \App\Models\Lead\LeadDisposition $leadDisposition
 * @property-read \App\Models\Lead\LeadStatus $leadStatus
 * @property-read \App\Models\Lead\LeadType $leadType
 * @property int $lead_provider_id The originator of the lead.  This will most likely be just BetterCarPeople
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLeadProviderId($value)
 * @property string|null $import_at
 * @property int|null $lead_list_id
 * @property-read Customer $customer
 * @method static \Database\Factories\Lead\LeadFactory factory(...$parameters)
 * @method static Builder|Lead readyForImport()
 * @method static Builder|Lead whereImportAt($value)
 * @method static Builder|Lead whereLeadListId($value)
 * @property array $meta_data
 * @method static Builder|Lead whereMetaData($value)
 * @method static Builder|Lead awaitingImport()
 */
class Lead extends Model
{
    use HasFactory;

    /**
     * @var string[] $dispatchesEvents
     */
    protected $dispatchesEvents = [
        'created' => LeadCreated::class
    ];

    protected $casts = [
        'meta_data' => 'array'
    ];

    protected $fillable = [
        'client_id', 'lead_type_id', 'sequence_id', 'last_sequence_action_identifier', 'customer_id',
        'first_name', 'last_name', 'full_name', 'lead_status_id', 'lead_disposition_id', 'lead_provider_id',
        'meta_data', 'lead_list_id'
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function leadType(): BelongsTo {
        return $this->belongsTo(LeadType::class, 'lead_type_id');
    }

    public function leadStatus(): BelongsTo {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    public function leadDisposition(): BelongsTo {
        return $this->belongsTo(LeadDisposition::class, 'lead_disposition_id');
    }

    public function scopeAwaitingImport(Builder $query): Builder {
        return $query->where('lead_status_id', LeadStatus::AWAITING_IMPORT);
    }

    /**
     * Scope that identifies leads that are ready to be imported by the system
     * @param Builder $query
     * @return Builder
     */
    public function scopeReadyForImport(Builder $query): Builder {
        return $this->awaitingImport()
            ->where('import_at', '<=', now());
    }

    /**
     * Get leads that will be ready to import on day
     * @param Builder $query
     * @param Carbon $dayToBeChecked
     * @return Builder
     */
    public function scopeReadyForImportOnDay(Builder $query, Carbon $dayToBeChecked): Builder {
        $startOfDay = $dayToBeChecked->startOfDay();
        $endOfDay = $dayToBeChecked->copy()->endOfDay();

        return $this->awaitingImport()
            ->whereBetween('import_at', [$startOfDay, $endOfDay]);
    }
}
