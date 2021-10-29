<?php

namespace App\Services\DataTransferObjects;

use Carbon\Carbon;

class SequenceActionData extends AbstractDataTransferObject {
    public int $task_type_id;
    public int $sequence_id;
    public Carbon $scheduled_start_time;
    public int $delay_in_seconds;
    public string $instructions;
}
