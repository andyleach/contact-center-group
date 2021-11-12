<?php

namespace App\Services\DataTransferObjects;

use App\Http\Requests\Web\UpdateClientPhoneNumberRequest;

class ClientPhoneNumberData {
    public int $id;
    public string $phoneNumber;
    public string $callHandling;
    public array $transferNumbers = [];

    public static function fromRequest(UpdateClientPhoneNumberRequest $request): ClientPhoneNumberData {
        $data = new self();
        $data->id = $request->get('id');
        $data->phoneNumber = $request->get('phoneNumber');
        $data->callHandling = $request->get('callHandling');
        $data->transferNumbers = $request->get('transferNumbers');
    }
}
