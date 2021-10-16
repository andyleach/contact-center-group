<?php

namespace App\Jobs\Lead;

use App\Actions\Customer\AssociateLeadWithExistingCustomer;
use App\Actions\Customer\CreateCustomerFromLead;
use App\Actions\Lead\DismissLead;
use App\Actions\Lead\LeadMatching\MatchLeadUsingCustomerContactInformation;
use App\Actions\Lead\Routing\RouteLeadByType;
use App\Actions\Sequence\AssignSequence;
use App\Contracts\Lead\PerformsLeadMatchingContract;
use App\Contracts\Lead\RoutesNewLeadsForClientContract;
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

        // Match lead to customer
            // If matched to customer
            app(AssociateLeadWithExistingCustomer::class);
                // Add new phone numbers to customer profile
                // Add new emails to customer profile
            // If we didn't match the lead to a customer
            app(CreateCustomerFromLead::class);
                // Create a new customer from the lead data

        // Perform duplicate checking.  We should support multiple duplication handling strategies. Strategy should be dictated by lead type
            // Strategies:
                // Dismiss lead if duplicate
                // Assign new sequence to original lead and dismiss
            // Exit out of job on identifying existence of duplicate

        // Route lead according to lead type
            app(RoutesNewLeadsForClientContract::class);
            // Assigns sequence
            // Creates first task

        $this->lead->lead_status_id = LeadStatus::IMPORT_COMPLETED;
        $this->lead->save();
        LeadImportCompleted::dispatch($this->lead);
    }
}
