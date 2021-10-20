<?php

namespace App\Models\LeadList;

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
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListStatus whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadListStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadListStatus extends Model
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
