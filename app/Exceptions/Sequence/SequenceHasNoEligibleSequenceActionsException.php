<?php

namespace App\Exceptions\Sequence;

use App\Models\Lead\Lead;
use App\Models\Sequence\Sequence;
use Exception;
use JetBrains\PhpStorm\Pure;

class SequenceHasNoEligibleSequenceActionsException extends Exception
{
    /**
     * @param Sequence $sequence
     * @param Lead $lead
     * @return $this
     */
    #[Pure] public static function forLead(Lead $lead, Sequence $sequence): self {
        return new self('Attempted to assign sequence('. $sequence->id.') to lead ('
            .$lead->id.') that has no actions');
    }
}
