<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LeadList\LeadListType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignType query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $label
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Campaign\CampaignTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignType whereUpdatedAt($value)
 */
class CampaignType extends Model
{
    use HasFactory;
}
