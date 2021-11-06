<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\StoreTwilioInboundCallRequest;
use App\Models\Call\TaskCall;
use App\Models\Client\ClientPhoneNumber;
use App\Models\Customer\CustomerPhoneNumber;
use App\Services\DataTransferObjects\InboundCallData;
use App\Services\InboundCallService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class TwilioInboundCallController extends Controller
{
    protected InboundCallService $service;

    /**
     *
     */
    #[Pure] public function __construct() {
        $this->service = new InboundCallService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTwilioInboundCallRequest  $request
     * @return JsonResponse
     */
    public function store(StoreTwilioInboundCallRequest $request): JsonResponse
    {
        $data = InboundCallData::fromTwilio($request);

        $clientPhoneNumber = ClientPhoneNumber::query()
            ->where('phone_number', $data->called)
            ->firstOrFail();

        $handlingType = $clientPhoneNumber->call_handling;
        if (ClientPhoneNumber::ROUTE_TO_AGENT == $handlingType) {
            $call = $this->service->createNewTaskCall($data);
        } else if (ClientPhoneNumber::MULTI_DIALER == $handlingType) {
            $call = $this->service->createNewMultiDialerCall($data);
        } else {
            throw new \Exception('Invalid Call Handling Type Specified');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
