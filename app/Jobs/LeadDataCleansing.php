<?php

namespace App\Jobs;

use App\Contacts\TwilioServiceContract;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadStatus;
use App\Services\Integrations\TwilioService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Exceptions\TwilioException;

/**
 * Here, we will take on the responsibility of cleansing our lead data.  We will not remove anything because we want to
 * maintain a history of what came in on our lead, but we will notate that the data is not valid so that the rest of our
 * system knows that it should not be used, or presented
 */
class LeadDataCleansing implements ShouldQueue {
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

    public function handle() {
        $this->lead->lead_status_id = LeadStatus::CLEANSING;
        $this->lead->save();

        $this->handleClensingOfLeadPhoneNumbers();
    }

    /**
     *
     */
    public function handleClensingOfLeadPhoneNumbers() {
        $twilioService = app(TwilioServiceContract::class);
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
