<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LeadList\LeadListEvent
 *
 * @property int $id
 * @property string $label
 * @property int $lead_list_event_type_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent whereLeadListEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $lead_list_status_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent whereLeadListStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEvent whereUserId($value)
 */
class CampaignEvent extends Model
{
    use HasFactory;
}
