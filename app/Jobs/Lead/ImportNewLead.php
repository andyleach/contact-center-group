<?php

namespace App\Jobs\Lead;

use App\Actions\Customer\AssociateLeadWithExistingCustomer;
use App\Actions\Customer\CreateCustomerFromLead;
use App\Actions\Customer\MatchOrCreateCustomerForLead;
use App\Actions\Lead\DismissLead;
use App\Actions\Lead\LeadMatching\MatchLeadUsingCustomerContactInformation;
use App\Actions\Lead\RouteLead;
use App\Actions\Lead\Routing\RouteLeadByType;
use App\Actions\Sequence\AssignSequence;
use App\Contracts\Lead\PerformsLeadMatchingContract;
use App\Contracts\Lead\RoutesNewLeadsForClientContract;
use App\Events\Lead\LeadImportCompleted;
use App\Events\Lead\LeadImportFailed;
use App\Events\Lead\LeadImportStarted;
use App\Http\Services\CustomerService;
use App\Http\Services\LeadImportingService;
use App\Models\Customer\Customer;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportNewLead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Lead $lead
     */
    protected Lead $lead;

    protected LeadImportingService $leadImportingService;

    protected CustomerService $customerService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;

        $this->leadImportingService = new LeadImportingService();
    }

    protected function failed() {
        $this->leadImportingService->failedImporting($this->lead);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->leadImportingService->startedImporting($this->lead);

        $lead = $this->handleCustomerAssociation($this->lead);

        $lead = $this->handleLeadDuplicationChecking($lead);

        $lead = $this->handleSequenceAssignment($lead);


        // Perform duplicate checking.  We should support multiple duplication handling strategies. Strategy should be dictated by lead type
            // Strategies:
                // Dismiss lead if duplicate
                // Assign new sequence to original lead and dismiss
            // Exit out of job on identifying existence of duplicate

        app(RouteLead::class)->route($this->lead);


        $this->leadImportingService->completedImporting($this->lead);
    }

    /**
     * @param Lead $lead
     * @return Lead
     */
    protected function handleCustomerAssociation(Lead $lead): Lead {
        $customer = $this->customerService->matchLeadToCustomer($this->lead);
        if (false == is_a($customer, Customer::class)) {
            $customer = $this->customerService->createCustomerFromLead($this->lead);
        }


        // attach the phone numbers
        // attach the emails

        return $lead;
    }

    protected function handleLeadDuplicationChecking(Lead $lead): Lead {
        return $lead;
    }

    public function handleSequenceAssignment(Lead $lead): Lead {
        // Perform sequence assignment via client configuration
        return $lead;
    }
}
