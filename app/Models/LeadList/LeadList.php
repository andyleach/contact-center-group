<?php

namespace App\Models\LeadList;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class LeadList extends Model
{
    use HasFactory;
}
