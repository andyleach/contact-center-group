<?php

namespace Tests\Mocks\Lead;

use App\Contracts\Lead\CreatesNewLeadContract;
use App\Http\DataTransferObjects\LeadData;
use App\Models\Lead\Lead;

class CreateNewLeadMock implements CreatesNewLeadContract {

    /**
     * @inheritDoc
     */
    public function handle(LeadData $data): Lead {
        return Lead::factory()->create();
    }
}
