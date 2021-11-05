<?php

namespace App\Services;

use App\Events\Task\TaskAssigned;
use App\Events\Task\TaskAssignmentCancelled;
use App\Events\Task\TaskExpired;
use App\Events\Task\TaskRemoved;
use App\Exceptions\Task\TaskAssignmentException;
use App\Exceptions\Task\TaskInProcessException;
use App\Exceptions\Task\TaskRemovalException;
use App\Models\Agent\Agent;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use App\Services\DataTransferObjects\TaskData;

class ClientPhoneNumberService {
    public function addPhoneNumber() {

    }

    public function addInteractiveVoiceResponseOption() {

    }

    public function buyPhoneNumber() {

    }
}
