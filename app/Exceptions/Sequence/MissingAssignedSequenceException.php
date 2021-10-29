<?php

namespace App\Exceptions\Sequence;

use App\Models\Lead\Lead;
use Exception;
use JetBrains\PhpStorm\Pure;

class MissingAssignedSequenceException extends Exception
{
    /**
     * @param Lead $lead
     * @return $this
     */
    #[Pure] public static function create(Lead $lead): self {
        return new self('Missing sequence for lead ('. $lead->id.')');
    }
}
