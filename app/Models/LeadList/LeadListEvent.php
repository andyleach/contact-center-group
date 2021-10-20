<?php

namespace App\Models\LeadList;

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
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent whereLeadListEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $lead_list_status_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent whereLeadListStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEvent whereUserId($value)
 */
class LeadListEvent extends Model
{
    use HasFactory;
}
