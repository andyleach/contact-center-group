<?php

namespace App\Jobs\Lead;

use App\Events\Lead\LeadImportCompleted;
use App\Events\Lead\LeadImportFailed;
use App\Events\Lead\LeadImportStarted;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportLeadReceivedFromLeadProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Lead $lead
     */
    protected Lead $lead;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    protected function failed() {
        $this->lead->lead_status_id = LeadStatus::IMPORT_FAILED;
        $this->lead->save();
        LeadImportFailed::dispatch($this->lead);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->lead->lead_status_id = LeadStatus::IMPORT_STARTED;
        $this->lead->save();
        LeadImportStarted::dispatch($this->lead);

        $this->lead->lead_status_id = LeadStatus::IMPORT_COMPLETED;
        $this->lead->save();
        LeadImportCompleted::dispatch($this->lead);
    }
}
