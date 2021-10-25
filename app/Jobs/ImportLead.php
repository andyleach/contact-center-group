<?php

namespace App\Jobs;

use App\Models\Customer\Customer;
use App\Models\Lead\Lead;
use App\Services\LeadImportingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Take a lead that has already been cleansed and allow it to be processed in our system.
 *
 * This includes the following stages:
 *
 * - Matching a lead to a customer
 * - Determining if that lead is a duplicate lead
 * - Assigning a sequence
 */
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
        $this->handleIdentifyingExistingCustomersWhichMayBeRelated();
    }

    public function handleIdentifyingExistingCustomersWhichMayBeRelated() {
        /** @var Collection|array<Customer> $customers */
        $customers = $this->service->matchLeadToCustomerUsingContactInformation($this->lead);
        foreach ($customers as $customer) {
            $this->service->storePointsOfCommonalityBetweenLeadAndCustomer($this->lead,$customer);
        }
    }

    public function handleDuplicateChecking() {
        // TODO: Identify if there is any lead in the system that is open, belongs to the same lead type, and has a high degree of matching contact information
        // TODO: If it is an exact match, including meta data flag it as a duplicate.
        // TODO: If it is a partial match, flag it as a possible duplicate and allow an agent to make the determination
    }

    public function handleAssigningOfSequenceToLead() {

    }
}
