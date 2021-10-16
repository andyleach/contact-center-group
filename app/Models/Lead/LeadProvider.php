<?php

namespace App\Models\Lead;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lead\LeadProvider
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadProvider whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadProvider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadProvider extends Model
{
    use HasFactory;

    const BETTER_CAR_PEOPLE = 1;
}
