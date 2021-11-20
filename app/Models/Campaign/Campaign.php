<?php

namespace App\Models\Campaign;

use App\Events\Campaign\CampaignCreated;
use App\Models\Client\Client;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
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
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign query()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereLeadListStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereLeadListTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereMaxLeadsToImportInDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Client $client
 * @property-read \App\Models\Campaign\CampaignStatus $leadListStatus
 * @property-read \App\Models\Campaign\CampaignType $leadListType
 * @property-read \Illuminate\Database\Eloquent\Collection|Lead[] $leads
 * @property-read int|null $leads_count
 * @property int $max_leads_to_import_per_day
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereMaxLeadsToImportPerDay($value)
 * @property string $start_work_at
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereStartWorkAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Lead[] $leadsAwaitingScheduling
 * @property-read int|null $leads_awaiting_scheduling_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Lead[] $leadsNotImported
 * @property-read int|null $leads_not_imported_count
 * @method static \Database\Factories\Campaign\CampaignFactory factory(...$parameters)
 */
class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'max_leads_to_import_per_day', 'campaign_type_id', 'client_id', 'start_work_at', 'campaign_status_id'
    ];

    public $dispatchesEvents = [
        'created' => CampaignCreated::class,
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
    public function campaignStatus(): BelongsTo {
        return $this->belongsTo(CampaignStatus::class, 'campaign_status_id');
    }

    /**
     * @return BelongsTo
     */
    public function campaignType(): BelongsTo {
        return $this->belongsTo(CampaignType::class, 'campaign_type_id');
    }

    /**
     * @return HasMany
     */
    public function leads(): HasMany {
        return $this->hasMany(Lead::class, 'campaign_id');
    }

    public function leadsAwaitingScheduling(): HasMany {
        return $this->leads()
            ->where('lead_status_id', LeadStatus::DRAFT);
    }

    public function leadsNotImported(): HasMany {
        return $this->leads()
            ->where(function($query) {
                $query->whereIn('lead_status_id', [
                    LeadStatus::DRAFT,
                    LeadStatus::AWAITING_IMPORT,
                    LeadStatus::IMPORT_STARTED,
                    LeadStatus::IMPORT_FAILED
                ]);
            });
    }
}
