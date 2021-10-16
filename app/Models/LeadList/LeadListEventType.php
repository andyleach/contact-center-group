<?php

namespace App\Models\LeadList;

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
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEventType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEventType query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEventType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEventType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListEventType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadListEventType extends Model
{
    use HasFactory;
}
