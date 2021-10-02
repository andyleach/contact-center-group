<?php

namespace App\Services\Team\Services;

use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Models\Provider;
use App\Models\Team\TeamPhoneNumber;
use App\Services\Team\DataTransferObjects\CreatePhoneNumberData;

class TeamService {

    /**
     * @param CreatePhoneNumberData $phoneNumberData The data needed to create a new team phone number
     * @return TeamPhoneNumber
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function createAndPurchasePhoneNumber(CreatePhoneNumberData $phoneNumberData): TeamPhoneNumber {
        $client = new Client(config('services.twilio.sid'), config('services.twilio.token'));
        $incomingPhoneNumber = $client->incomingPhoneNumbers->create([
            'PhoneNumber' => $phoneNumberData->phone_number,
            'FriendlyName' => $phoneNumberData->friendly_name,
            'SmsMethod' => 'post',
            'SmsUrl' => route('twilio.sms.store'),
            'VoiceMethod' => 'post',
            'VoiceUrl' => route('twilio.call.store'),
        ]);

        return TeamPhoneNumber::create([
            'phone_number'       => $incomingPhoneNumber->phoneNumber,
            'friendly_name'      => $incomingPhoneNumber->friendlyName,
            'transfer_number'    => $phoneNumberData->transfer_number,
            'forward_number'     => $phoneNumberData->forward_number,
            'provider_id'        => Provider::TWILIO,
            'team_id'            => $phoneNumberData->team_id,
            'provider_unique_id' => $incomingPhoneNumber->sid,
            //'api_version'        => $incomingPhoneNumber->apiVersion,
            'purchased_at'       => Carbon::parse($incomingPhoneNumber->dateCreated),
        ]);
    }
}
