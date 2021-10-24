<?php

namespace App\Jobs\LeadImportStages;

use App\Models\Lead\Lead;
use App\Services\LeadImportingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class AbstractLeadImportStage implements ShouldQueue {
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
}
