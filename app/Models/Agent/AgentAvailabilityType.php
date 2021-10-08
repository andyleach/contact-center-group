<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentAvailabilityType extends Model
{
    use HasFactory;

    const UNAVAILABLE = 1;
    const AVAILABLE = 2;
    const WINDING_DOWN = 3;
}
