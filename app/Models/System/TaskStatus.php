<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TaskStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    const DRAFT = 1;
    const PENDING = 2;
    const ASSIGNED = 3;
    const IN_PROCESS = 4;
    const WRAPPING_UP = 5;
    const PENDING_CLOSE = 6;
    const CLOSED = 7;
    const CLOSE_FAILED = 8;
    const REMOVED = 9;
}
