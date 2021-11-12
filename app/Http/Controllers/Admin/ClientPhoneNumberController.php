<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreClientPhoneNumberRequest;
use App\Http\Resources\ClientPhoneNumberResource;
use App\Models\Client\Client;
use App\Models\Client\ClientPhoneNumber;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Twilio\Exceptions\TwilioException;

class ClientPhoneNumberController extends Controller
{
    /**
     * @var ClientService $service
     */
    protected ClientService $service;

    /**
     *
     */
    public function __construct() {
        $this->service = app(ClientService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): AnonymousResourceCollection
    {
        $query = ClientPhoneNumber::query()
            ->with('clientPhoneNumberStatus');

        if (request()->has('client_id')) {
            $query->where('client_id', request()->get('client_id'));
        }

        $clientPhoneNumbers = $query->get();

        return ClientPhoneNumberResource::collection($clientPhoneNumbers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreClientPhoneNumberRequest  $request
     * @return ClientPhoneNumberResource
     */
    public function store(StoreClientPhoneNumberRequest $request): ClientPhoneNumberResource
    {
        $client = Client::findOrFail($request->get('client_id'));

        try {
            $clientPhoneNumber = $this->service->purchasePhoneNumber($client, $request->get('phoneNumber'));

            return ClientPhoneNumberResource::make($clientPhoneNumber);
        } catch (\Exception $exception) {
            abort(500, $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client\ClientPhoneNumber  $clientPhoneNumber
     * @return \Illuminate\Http\Response
     */
    public function show(ClientPhoneNumber $clientPhoneNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client\ClientPhoneNumber  $clientPhoneNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientPhoneNumber $clientPhoneNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client\ClientPhoneNumber  $clientPhoneNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientPhoneNumber $clientPhoneNumber)
    {
        //
    }
}
