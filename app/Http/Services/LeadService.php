<?php

namespace App\Http\Services;

use App\Actions\Lead\DataTransferObjects\LeadData;
use App\Contracts\Lead\CreatesNewLeadContract;
use App\Events\Lead\LeadReceived;
use App\Jobs\Lead\ImportLeadReceivedFromLeadProvider;
use App\Models\Lead\Lead;

class LeadService {

    /**
     * @var CreatesNewLeadContract|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected CreatesNewLeadContract $createLeadAction;

    /**
     *
     */
    public function __construct() {
        $this->createLeadAction = app(CreatesNewLeadContract::class);
    }

    /**
     * @param LeadData $data
     * @return Lead
     * @throws \Exception
     */
    public function createNewLeadWithDataFromLeadProvider(LeadData $data): Lead {
        // Create the new lead
        $lead = $this->createLeadAction->handle($data);

        LeadReceived::dispatch($lead);

        ImportLeadReceivedFromLeadProvider::dispatch($lead);

        return $lead;
    }
}
