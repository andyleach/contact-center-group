<?php

namespace App\Services\Integrations;

use App\Contracts\TwilioServiceContract;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Api\V2010\Account\CallInstance;
use Twilio\Rest\Api\V2010\Account\Conference\ParticipantInstance;
use Twilio\Rest\Api\V2010\Account\ConferenceInstance;
use Twilio\Rest\Api\V2010\AccountInstance;
use Twilio\Rest\Client;
use Twilio\Rest\Lookups\V1\PhoneNumberInstance;
use Twilio\TwiML\VoiceResponse;
use App\Models\Client\Client as OurClient;

class TwilioService implements TwilioServiceContract {
    /**
     * @var Client $twilio
     */
    protected Client $twilio;

    /**
     * Initialize the twilio client
     *
     * @throws ConfigurationException
     */
    public function __construct() {
        $sid = config('services.account_sid');
        $token = config('services.auth_token');

        $this->twilio = new Client($sid, $token);
    }

    /**
     * Scopes the service to performing actions for a specific client instead of utilizing the global scope
     *
     * @param OurClient $client
     * @return $this
     * @throws ConfigurationException
     */
    public function forClient(OurClient $client): self {
        $sid = config('services.account_sid');
        $token = config('services.auth_token');

        $this->twilio = new Client($sid, $token, $client->twilio_sid);
    }

    /**
     * Creates a sub-account in Twilio that allows for us to track the cost of everything we do for a client
     *
     * @param string $friendlyName
     * @return AccountInstance
     * @throws TwilioException
     */
    public function createSubAccount(string $friendlyName): AccountInstance {
        return $this->twilio->api->v2010->accounts
            ->create(["friendlyName" => $friendlyName]);
    }

    /**
     * Delete a phone number from our list of purchased numbers
     *
     * @param string $friendlyName The friendly name for the number
     * @param string $phoneNumber The phone number we want to purchase
     *
     * @return \Twilio\Rest\Api\V2010\Account\IncomingPhoneNumberInstance
     * @throws TwilioException
     */
    public function purchasePhoneNumber(string $phoneNumber, string $friendlyName = '') {
        return  $this->twilio->incomingPhoneNumbers->create([
            'FriendlyName' => $friendlyName,
            'PhoneNumber'  => $phoneNumber,
        ]);
    }

    /**
     * Delete a phone number from our list of purchased numbers
     *
     * @param string $phoneNumberSid
     * @return bool
     * @throws TwilioException
     */
    public function releasePhoneNumber(string $phoneNumberSid) {
        return $this->twilio->incomingPhoneNumbers($phoneNumberSid)->delete();
    }

    /**
     * @param int $areaCode The area code of the phone number
     * @param int $limit    The max results
     * @return array
     */
    public function getAvailableLocalPhoneNumbers(int $areaCode, int $limit = 20): array {
        return $this->twilio->availablePhoneNumbers('US')
            ->local
            ->read(['areaCode' => $areaCode], $limit);
    }

    /**
     * If the number is invalid, this request will return an HTTP 404 status code.
     *
     * If you plan to store the phone number after validating, we recommend storing the full E.164 formatted number
     * returned in the phone number field. Most other Twilio services require the E.164 format for phone numbers.
     *
     * Overview:
     * https://www.twilio.com/docs/lookup/tutorials
     *
     * Formatting:
     * https://www.twilio.com/docs/lookup/tutorials/validation-and-formatting#validate-a-national-phone-number
     *
     * @param string $phoneNumber
     * @return PhoneNumberInstance
     * @throws TwilioException
     */
    public function lookup(string $phoneNumber): PhoneNumberInstance {
        return $this->twilio->lookups->v1->phoneNumbers($phoneNumber)
            ->fetch([]);
    }

    /**
     * https://www.twilio.com/docs/voice/tutorials/how-to-make-outbound-phone-calls-php
     *
     * @param string     $to      who to send the call too
     * @param string     $from    the number we should display on caller id
     * @param array|null $options the additional twilio options for the call
     *
     * @return CallInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function createOutboundCall(string $to, string $from, array $options = null): CallInstance {
        return $this->twilio->calls->create($to, $from, $options);
    }

    /**
     * @param string $conferenceSid the conference id from twilio
     * @param string $to            who to send the call too
     * @param string $from          the number we should display on caller id
     * @param array  $options       the additional options for the call that will be added to the conference
     *
     * @return ParticipantInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function addConferenceParticipant(string $conferenceSid, string $to, string $from, array $options = []): ParticipantInstance {
        return $this->twilio->conferences($conferenceSid)
            ->participants
            ->create($from, $to, $options);
    }

    /**
     * @param string $conferenceSid the twilio ConferenceSid
     * @param string $label         the label of the participant you wish to retrieve
     *
     * @return ParticipantInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function removeParticipantFromHoldByLabel(string $conferenceSid, string $label): ParticipantInstance {
        return $this->twilio->conferences($conferenceSid)
            ->participants($label)
            ->update([
                    "hold" => false,
                ]
            );
    }

    /**
     * @param string $conferenceSid The unique id of the conference
     * @param string $label         The participant label
     * @param array  $options       the options
     *
     * @return ParticipantInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function updateParticipantByLabel(string $conferenceSid, string $label, array $options): ParticipantInstance {
        return $this->twilio->conferences($conferenceSid)->participants($label)->update($options);
    }

    /**
     * @param string $conferenceSid the twilio ConferenceSid
     * @param string $label         the label of the participant you wish to retrieve
     *
     * @return ParticipantInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function placeParticipantOnHoldByLabel(string $conferenceSid, string $label): ParticipantInstance {
        return $this->twilio->conferences($conferenceSid)
            ->participants($label)
            ->update([
                    "hold" => true,
                ]
            );
    }

    /**
     * @param string $conferenceSid the twilio ConferenceSid
     * @param string $label         the label of the participant you wish to retrieve
     *
     * @return ParticipantInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function getConferenceParticipantByLabel(string $conferenceSid, string $label): ParticipantInstance {
        return $this->twilio->conferences($conferenceSid)
            ->participants($label)
            ->fetch();
    }

    /**
     * @param string $conferenceSid the twilio ConferenceSid
     *
     * @return array|ParticipantInstance[]
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function getAllConferenceParticipants(string $conferenceSid): array {
        if (empty($conferenceSid)) {
            throw new TwilioException('No conference sid provided');
        }

        return $this->twilio->conferences($conferenceSid)
            ->participants
            ->read([]);
    }

    /**
     * Determine if there are any conference participants still on the conference
     *
     * @param string $conferenceSid The Twilio conference identifier
     * @return bool
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function hasConferenceParticipants(string $conferenceSid): bool {
        $conferenceParticipants = $this->getAllConferenceParticipants($conferenceSid);

        return !empty($conferenceParticipants);
    }

    /**
     * @param string $conferenceSid the twilio ConferenceSid
     *
     * @return ConferenceInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function endConferenceCall(string $conferenceSid): ConferenceInstance {
        $conference = $this->twilio->conferences($conferenceSid)->fetch();
        if ($conference->status !== "completed") {
            $conference = $this->twilio->conferences($conferenceSid)
                ->update(["status" => "completed"]);
        }

        return $conference;
    }

    /**
     * @param string $conferenceSid the twilio ConferenceSid
     * @param string $label         the label of the participant you wish to retrieve
     *
     * @return ParticipantInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function removeParticipantFromConferenceByLabel(string $conferenceSid, string $label): ParticipantInstance {
        return $this->twilio->conferences($conferenceSid)
            ->participants($label)
            ->update(["status" => "completed"]);
    }

    /**
     * @param string $conferenceSid the twilio ConferenceSid
     *
     * @return CallInstance
     * @throws TwilioException
     */
    public function setCustomerTwimlToHangup(string $conferenceSid): CallInstance {
        $v = new VoiceResponse();

        $customer = $this->twilio->conferences($conferenceSid)
            ->participants('Customer')
            ->fetch();
        return $this->twilio->calls($customer->callSid)->update(['twiml' => $v]);
    }

    /**
     * @param string $callSid the twilio CallSid
     *
     * @return CallInstance
     * @throws TwilioException
     */
    public function endCall(string $callSid): CallInstance {
        return $this->twilio->calls($callSid)->update(["Status" => "completed"]);
    }

    /**
     * Send an arbitrary update to an existing call
     *
     * @param string $callSid the twilio CallSid
     * @param array  $options the twilio options
     *
     * @return CallInstance
     * @throws TwilioException
     */
    public function updateCall(string $callSid, array $options = []): CallInstance {
        return $this->twilio->calls($callSid)->update($options);
    }

    /**
     * @param string $callSid the call sid to get info for
     *
     * @return CallInstance
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function getCallInfo(string $callSid): CallInstance {
        return $this->twilio->calls($callSid)->fetch();
    }

    /**
     * Sends a call to voicemail
     *
     * https://support.twilio.com/hc/en-us/articles/223132867-Recording-a-Phone-Call-with-Twilio
     *
     * @param string $callSid The call we want to send to voicemail
     * @param string $message The message we want to play
     *
     * @return CallInstance
     * @throws TwilioException
     */
    public function sendCustomerToVoicemail(string $callSid, string $message): CallInstance {
        $voiceResponse = new VoiceResponse();
        $voiceResponse->say($message);
        $voicemail = $voiceResponse->record();
        $voicemail->setMaxLength(120);
        $voicemail->setFinishOnKey('*');
        $voicemail->setRecordingStatusCallback(route('twilio.voicemail.status'));
        $voicemail->setRecordingStatusCallbackEvent('in-progress completed absent');
        $voicemail->setRecordingStatusCallbackMethod('POST');

        return $this->updateCall($callSid, [
            'twiml' => $voiceResponse
        ]);
    }
}
