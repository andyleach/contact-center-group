<?php

namespace App\Models\LeadList;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LeadList\LeadListType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListType query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $label
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\LeadList\LeadListTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListType whereUpdatedAt($value)
 */
class LeadListType extends Model
{
    use HasFactory;
}
