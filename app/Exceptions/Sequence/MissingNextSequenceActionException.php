<?php

namespace App\Exceptions\Sequence;

use App\Models\Lead\Lead;
use App\Models\Pivot\LeadSequence;
use Exception;

class MissingNextSequenceActionException extends Exception
{
    /**
     * @param LeadSequence $leadSequence
     * @return $this
     */
    public static function create(LeadSequence $leadSequence): self {
        return new self('Missing next sequence action on sequence '. $leadSequence->sequence->label
            .'('. $leadSequence->sequence_id.') for lead ('. $leadSequence->lead_id.')');
    }
}
