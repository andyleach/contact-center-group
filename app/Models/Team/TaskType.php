<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;

    const INBOUND_CALL = 1;
    const OUTBOUND_CALL = 2;
    const MISSED_CALL_CALLBACK = 3;
    const NON_WORKING_HOURS_CALLBACK = 4;
}
