<?php
/**
 * An opportunity indicates that a potential actionable item has been achieved by and agent.
 */
namespace App\Models\Opportunity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Opportunity\Opportunity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunity query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Opportunity whereUpdatedAt($value)
 */
class Opportunity extends Model
{
    use HasFactory;
}
