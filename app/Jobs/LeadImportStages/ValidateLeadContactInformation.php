<?php

namespace App\Jobs\LeadImportStages;

use App\Services\Integrations\TwilioService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Twilio\Exceptions\TwilioException;

class ValidateLeadContactInformation extends AbstractLeadImportStage implements ShouldQueue
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->handleValidationOfLeadPhoneNumbers();
    }

    public function handleValidationOfLeadPhoneNumbers() {
        $twilioService = new TwilioService();
        $leadPhoneNumbers = $this->lead->leadPhoneNumbers;
        foreach ($leadPhoneNumbers as $leadPhoneNumber) {
            try {
                $phoneNumberInstance = $twilioService->lookup($leadPhoneNumber->phone_number);
                $leadPhoneNumber->phone_number = $phoneNumberInstance->phoneNumber;
                $leadPhoneNumber->is_valid = true;
                $leadPhoneNumber->save();
            } catch (TwilioException $exception) {
                $leadPhoneNumber->is_valid = false;
                $leadPhoneNumber->save();
            }
        }
    }
}
