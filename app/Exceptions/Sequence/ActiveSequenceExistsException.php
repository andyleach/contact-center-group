<?php

namespace App\Exceptions\Sequence;

use App\Models\Lead\Lead;
use Exception;
use JetBrains\PhpStorm\Pure;

class ActiveSequenceExistsException extends Exception
{
    /**
     * @param Lead $lead
     * @return $this
     */
    #[Pure] public static function forLead(Lead $lead): self {
        return new self('The lead('. $lead->id.') already has an active sequence');
    }
}
