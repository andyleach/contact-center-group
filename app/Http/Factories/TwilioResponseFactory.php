<?php

namespace App\Http\Factories;

use App\Models\Call\TaskCall;
use ContactCenter\lib\Call\Handlers\TwilioConferenceHandler;
use Twilio\TwiML\VoiceResponse;

class TwilioResponseFactory {
    public function inboundTaskCall(TaskCall $taskCall): VoiceResponse {
        $dialParams = [
            'timeout' => 45,
        ];

        if (true) {
            // Merge existing settings with recording settings
            $dialParams = array_merge($dialParams, config('contact-center.recording-settings'));
        }

        $voiceResponse = new VoiceResponse();
        $dial = $voiceResponse->dial('', $dialParams);
        $twilioConference = $dial->conference($taskCall->id, [
            //'participantLabel' => TwilioConferenceHandler::PARTICIPANT_DEALERSHIP_CUSTOMER,
        ]);
        $twilioConference->setStatusCallbackMethod('POST');
        $twilioConference->setStartConferenceOnEnter(true);
        $twilioConference->setEndConferenceOnExit(true);
        $twilioConference->setStatusCallback(config('app.webhook_url')
            . '/twilio/inbound/conference-events');
        $twilioConference->setStatusCallbackEvent('start end join leave');// mute hold speaker

        return $voiceResponse;
    }
}
