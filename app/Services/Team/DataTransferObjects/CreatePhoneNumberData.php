<?php

namespace App\Services\Team\DataTransferObjects;

class CreatePhoneNumberData {
    public string $friendly_name;
    public string $phone_number;
    public string $forward_number;
    public string $transfer_number;
    public int $team_id;
}
