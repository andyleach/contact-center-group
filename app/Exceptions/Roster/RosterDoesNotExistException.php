<?php

namespace App\Exceptions\Roster;

use Exception;

class RosterDoesNotExistException extends Exception
{
    protected $message = 'No roster exists for the requested dat';
}
