<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AvailablePhoneNumbersResource;
use App\Services\Integrations\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TwilioPhoneNumberSearchController extends Controller
{
    /**
     * @var TwilioService $service
     */
    protected TwilioService $service;

    /**
     *
     */
    public function __construct() {
        $this->service = new TwilioService();
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function searchLocalPhoneNumbers(Request $request): AnonymousResourceCollection {
        $this->validate($request, [
            'areaCode' => 'required|int'
        ]);

        $phoneNumbers = $this->service->getAvailableLocalPhoneNumbers($request->get('areaCode'), 5);

        return AvailablePhoneNumbersResource::collection($phoneNumbers);
    }
}
