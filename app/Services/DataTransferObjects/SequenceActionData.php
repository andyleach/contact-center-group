<?php

namespace App\Services\DataTransferObjects;

use Carbon\Carbon;
use Database\Factories\Sequence\SequenceActionDataFactory;

class SequenceActionData extends AbstractDataTransferObject {

    /**
     * Ensures that you can use factories to create sequence data.
     *
     * @return SequenceActionDataFactory
     */
    public static function newFactory(): SequenceActionDataFactory {
        return new SequenceActionDataFactory();
    }

    /**
     * @var ?int $sequence_action_id
     */
    public ?int $sequence_action_id = null;
    public int $task_type_id;
    public int $sequence_id;
    public Carbon $scheduled_start_time;
    public int $delay_in_seconds;
    public string $instructions;
    public int $ordinal_position;
}
