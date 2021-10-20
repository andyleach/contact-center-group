<?php

namespace App\Models\LeadList;

use App\Events\LeadList\LeadListCreated;
use App\Models\Client\Client;
use App\Models\Lead\Lead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\LeadList\LeadList
 *
 * @property int $id
 * @property string $label
 * @property int $max_leads_to_import_in_day
 * @property int $lead_list_status_id
 * @property int $lead_list_type_id
 * @property int $client_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereLeadListStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereLeadListTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereMaxLeadsToImportInDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadList whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Client $client
 * @property-read \App\Models\LeadList\LeadListStatus $leadListStatus
 * @property-read \App\Models\LeadList\LeadListType $leadListType
 * @property-read \Illuminate\Database\Eloquent\Collection|Lead[] $leads
 * @property-read int|null $leads_count
 */
class LeadList extends Model
{
    use HasFactory;

    public $dispatchesEvents = [
        'created' => LeadListCreated::class,
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * @return BelongsTo
     */
    public function leadListStatus(): BelongsTo {
        return $this->belongsTo(LeadListStatus::class, 'lead_list_status_id');
    }

    /**
     * @return BelongsTo
     */
    public function leadListType(): BelongsTo {
        return $this->belongsTo(LeadListType::class, 'lead_list_type_id');
    }

    /**
     * @return HasMany
     */
    public function leads(): HasMany {
        return $this->hasMany(Lead::class, 'list_id');
    }
}
