<?php

return [
    'recording-settings' => [
        'record' => 'record-from-answer',
        'recordingStatusCallback' => config('app.url') . '/twilio/recording-status-callback',
        'recordingStatusCallbackMethod' => 'POST',
        'recordingStatusCallbackEvent' => 'in-progress completed absent'
    ],
];
