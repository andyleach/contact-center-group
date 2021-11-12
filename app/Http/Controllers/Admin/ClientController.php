<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientPhoneNumberResource;
use App\Http\Resources\ClientResource;
use App\Models\Client\Client;
use App\Models\Client\ClientPhoneNumber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return inertia()->render('Client/Index', [
            'clients' => ClientResource::collection(Client::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $client = Client::create([
            'label' => $request->get('label')
        ]);

        return \Redirect::route('clients.edit', [
            'client' => $client->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client\Client  $client
     * @return Response
     */
    public function show(Client $client): Response
    {
        // TODO: Show a client report
        return inertia()->render('Client/Edit', [
            'client' => $client
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Client  $client
     * @return Response
     */
    public function edit(Client $client): Response
    {
        $clientPhoneNumbers = ClientPhoneNumber::query()
            ->where('client_id', $client->id)
            ->with('clientPhoneNumberStatus')
            ->get();

        return inertia()->render('Client/Edit', [
            'client' => $client,
            'clientPhoneNumbers' => ClientPhoneNumberResource::collection($clientPhoneNumbers)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client\Client  $client
     * @return Response
     */
    public function update(Request $request, Client $client): Response
    {
        $client->update($request->toArray());

        return inertia()->render('Client/Edit', [
            'client' => $client
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client\Client  $client
     * @return Response
     */
    public function destroy(Client $client): Response
    {
        return inertia()->render('Client/Edit', [
            'client' => $client
        ]);
    }
}
