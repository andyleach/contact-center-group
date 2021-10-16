<?php

namespace App\Models\Lead;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lead\LeadType
 *
 * @property int $id
 * @property string $label
 * @property string $description
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadType extends Model
{
    use HasFactory;
}
