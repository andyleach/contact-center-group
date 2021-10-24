<?php

namespace App\Jobs;

use App\Jobs\LeadImportStages\DetermineIfLeadIsDuplicate;
use App\Jobs\LeadImportStages\IdentifyPossibleRelatedCustomersForLead;
use App\Jobs\LeadImportStages\IdentifySequenceToBeAssignedToLead;
use App\Jobs\LeadImportStages\ValidateLeadContactInformation;
use App\Models\Customer\Customer;
use App\Models\Lead\Lead;
use App\Services\CustomerService;
use App\Services\DataTransferObjects\LeadData;
use App\Services\LeadImportingService;
use App\Services\LeadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class ImportLead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Lead $lead
     */
    protected Lead $lead;

    protected LeadImportingService $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;

        $this->service = new LeadImportingService();
    }

    /**
     * We failed the job, what should we do
     */
    protected function failed() {
        $this->service->failedImporting($this->lead);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->service->startedImporting($this->lead);

        Bus::chain([
            //new ValidateLeadContactInformation($this->lead),
            new IdentifyPossibleRelatedCustomersForLead($this->lead),
            new DetermineIfLeadIsDuplicate($this->lead),
            new IdentifySequenceToBeAssignedToLead($this->lead),
            function () {
                $this->service->completedImporting($this->lead);
            },
        ])->dispatch();
    }
}
