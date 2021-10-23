<?php

namespace App\Jobs;

use App\Models\Customer\Customer;
use App\Models\Lead\Lead;
use App\Services\CustomerService;
use App\Services\DataTransferObjects\LeadData;
use App\Services\LeadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportLead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var LeadData $leadData
     */
    protected LeadData $leadData;

    protected LeadService $leadService;

    protected CustomerService $customerService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(LeadData $leadData)
    {
        $this->leadData = $leadData;

        $this->leadService = new LeadService();
        $this->customerService = new CustomerService();
    }

    protected function failed() {
        $this->leadService->failedImporting($this->lead);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lead = $this->leadService->createLead($this->leadData);

        $this->leadService->startedImporting($lead);

        $lead = $this->handleCustomerMatching($lead);

        $lead = $this->handleLeadDuplicationChecking($lead);

        $lead = $this->handleSequenceAssignment($lead);


        // Perform duplicate checking.  We should support multiple duplication handling strategies. Strategy should be dictated by lead type
            // Strategies:
                // Dismiss lead if duplicate
                // Assign new sequence to original lead and dismiss
            // Exit out of job on identifying existence of duplicate

        //app(RouteLead::class)->route($this->lead);


        $this->leadService->completedImporting($lead);
    }

    /**
     * @param Lead $lead
     * @return Lead
     */
    protected function handleCustomerMatching(Lead $lead): Lead {
        $customer = $this->customerService->matchLeadToCustomer();
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
