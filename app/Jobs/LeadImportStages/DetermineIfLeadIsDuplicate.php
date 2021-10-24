<?php

namespace App\Jobs\LeadImportStages;

use Illuminate\Contracts\Queue\ShouldQueue;

class DetermineIfLeadIsDuplicate extends AbstractLeadImportStage implements ShouldQueue
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TODO: Identify if there is any lead in the system that is open, belongs to the same lead type, and has a high degree of matching contact information
        // TODO: If it is an exact match, including meta data flag it as a duplicate.
        // TODO: If it is a partial match, flag it as a possible duplicate and allow an agent to make the determination

        // ??????????
        // Perform duplicate checking.  We should support multiple duplication handling strategies. Strategy should be dictated by lead type
        // Strategies:
        // Dismiss lead if duplicate
        // Assign new sequence to original lead and dismiss
        // Exit out of job on identifying existence of duplicate
    }
}
