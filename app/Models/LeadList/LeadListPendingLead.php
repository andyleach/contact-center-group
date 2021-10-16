<?php

namespace App\Models\LeadList;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LeadList\LeadListPendingLead
 *
 * @property int $id
 * @property string $label
 * @property int $lead_list_id
 * @property int $lead_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead whereLeadListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListPendingLead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadListPendingLead extends Model
{
    use HasFactory;
}
