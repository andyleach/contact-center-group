<?php

namespace App\Models\Roster;

use App\Models\Agent\Agent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Roster extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany
     */
    public function agents(): BelongsToMany {
        return $this->belongsToMany(Agent::class, 'roster_id', 'agent_id');
    }
}
