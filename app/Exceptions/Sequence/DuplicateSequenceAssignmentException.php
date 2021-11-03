<?php

namespace App\Exceptions\Sequence;

use App\Models\Lead\Lead;
use App\Models\Sequence\Sequence;
use Exception;
use JetBrains\PhpStorm\Pure;

class DuplicateSequenceAssignmentException extends Exception
{
    /**
     * @param Lead $lead
     * @param Sequence $sequence
     * @return $this
     */
    #[Pure] public static function forLead(Sequence $sequence, Lead $lead): self {
        return new self('The sequence('. $sequence->id.') has previously been assigned to lead ('.$lead->id.')');
    }
}
