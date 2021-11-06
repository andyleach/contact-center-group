<?php

namespace App\Services;

use App\Jobs\MatchTaskToAnExistingLead;
use App\Models\Call\MultiDialerCall;
use App\Models\Call\TaskCall;
use App\Models\Call\TaskCallParticipantType;
use App\Models\Task\Task;
use App\Services\DataTransferObjects\InboundCallData;
use App\Services\DataTransferObjects\TaskData;

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

    public function createNewTaskCall(InboundCallData $data): TaskCall {
        // Map the new inbound call data to our task data dto
        $taskData = TaskData::fromInboundCallData($data);

        /** @var Task $task */
        $task = app(TaskQueueService::class)->createTask($taskData);

        /** @var TaskCall $taskCall */
        $taskCall = $task->taskCall()->create([
            'provider_id' => $data->provider_id,
            'call_provider_id' => $data->call_sid,
            'client_phone_number_id' => $data->clientPhoneNumber->id,
            'direction' => 'Inbound',
        ]);

        // Create a participant record for the caller
        $taskCall->taskCallParticipants()->create([
            'task_call_participant_type_id' => TaskCallParticipantType::CLIENT_CUSTOMER,
            'agent_id' => null,
        ]);

        MatchTaskToAnExistingLead::dispatch($task);

        return $taskCall;
    }

    public function createNewMultiDialerCall(InboundCallData $data): MultiDialerCall {
        return new MultiDialerCall();
    }
}
