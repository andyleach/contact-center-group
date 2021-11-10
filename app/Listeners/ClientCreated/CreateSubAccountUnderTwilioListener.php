<?php

namespace App\Listeners\ClientCreated;

use App\Events\Client\ClientCreated;
use App\Services\Integrations\TwilioService;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Twilio\Exceptions\TwilioException;

/**
 * Responsible for creating a sub-account in Twilio for all of the phone numbers we purchase.  This will allow for
 * us to track cost metrics against each client
 */
class CreateSubAccountUnderTwilioListener implements ShouldQueue, ShouldBeUniqueUntilProcessing {
    /**
     * @param ClientCreated $clientCreated
     * @throws TwilioException
     */
    public function handle(ClientCreated $clientCreated) {
        $account = app(TwilioService::class)->createSubAccount($clientCreated->client->label);

        $clientCreated->client->twilio_sid = $account->sid;
        $clientCreated->client->save();
    }
}
