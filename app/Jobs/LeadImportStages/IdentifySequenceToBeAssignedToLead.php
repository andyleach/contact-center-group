<?php

namespace App\Jobs\LeadImportStages;

use Illuminate\Contracts\Queue\ShouldQueue;

class IdentifySequenceToBeAssignedToLead extends AbstractLeadImportStage implements ShouldQueue
{

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
