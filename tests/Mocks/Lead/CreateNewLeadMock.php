<?php

namespace Tests\Mocks\Lead;

use App\Actions\Lead\DataTransferObjects\LeadData;
use App\Contracts\Lead\CreatesNewLeadContract;
use App\Models\Lead\Lead;

class CreateNewLeadMock implements CreatesNewLeadContract {

    /**
     * @inheritDoc
     */
    public function handle(LeadData $data): Lead {
        return Lead::factory()->create();
    }
}
