<?php

namespace App\Models\Team;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamPhoneNumber extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function team(): BelongsTo {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
