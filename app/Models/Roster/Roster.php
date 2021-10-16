<?php

namespace App\Models\Roster;

use App\Models\Agent\Agent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Roster\Roster
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Agent[] $agents
 * @property-read int|null $agents_count
 * @method static \Illuminate\Database\Eloquent\Builder|Roster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roster query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Roster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roster whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roster whereUpdatedAt($value)
 */
class Roster extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date'
    ];

    /**
     * @return BelongsToMany
     */
    public function agents(): BelongsToMany {
        return $this->belongsToMany(Agent::class, 'roster_id', 'agent_id');
    }
}
