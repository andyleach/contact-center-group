<?php

namespace App\Services;

use App\Services\DataTransferObjects\InboundCallData;

class InboundCallService {
    /**
     * @param InboundCallData $data
     */
    public function handleNewInboundCallComingIntoSystemFromProvider(InboundCallData $data) {
        // Determine if call handling is set to forward only.  If it is, do not create a task for the call
        // Perform some kind of temporary lead matching if possible
            // If no lead exists, create a new lead
                // Create a new task, and use phone number IVR to determine what queue to place the call into.
                    // The task should be marked as first contact so that if the call is attributed to a new lead we can orphan it.
            // If lead exists
                // See if there is an open task being actively worked by an agent and attach the call to that task and route it to the agent
                // If no open task exists, place the task into the queue
    }
}
