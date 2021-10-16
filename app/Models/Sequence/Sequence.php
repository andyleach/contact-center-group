<?php

namespace App\Models\Sequence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sequence\Sequence
 *
 * @property int $id
 * @property string $label
 * @property string $description
 * @property mixed $actions
 * @property float $cost_per_lead_in_usd
 * @property int $client_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereCostPerLeadInUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sequence extends Model
{
    use HasFactory;
}
