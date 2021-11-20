<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LeadList\LeadListEventType
 *
 * @property int $id
 * @property string $label
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEventType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEventType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEventType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEventType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignEventType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CampaignEventType extends Model
{
    use HasFactory;
}
