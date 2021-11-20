<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LeadList\LeadListStatus
 *
 * @property int $id
 * @property string $label
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignStatus whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CampaignStatus extends Model
{
    use HasFactory;

    const CREATED          = 1;
    const CONFIRMED        = 2;
    const IMPORT_STARTED   = 3;
    const IMPORT_COMPLETED = 4;
    const COMPLETED        = 5;
    const TERMINATED       = 6;
    const PAUSED           = 7;
}
