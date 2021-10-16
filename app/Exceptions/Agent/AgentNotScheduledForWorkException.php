<?php

namespace App\Exceptions\Agent;

use Exception;

class AgentNotScheduledForWorkException extends Exception
{
    protected $message = 'Agent has not been scheduled for work';
}
