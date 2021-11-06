<?php

namespace App\Http\Controllers\Api;

use App\Events\Lead\LeadReceived;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreLeadRequest;
use App\Models\Lead\Lead;
use App\Models\Lead\LeadProvider;
use App\Services\DataTransferObjects\LeadData;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadApiController extends Controller
{
    protected LeadService $service;

    /**
     *
     */
    public function __construct() {
        $this->service = new LeadService();
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
     * @param  StoreLeadRequest  $request
     * @return JsonResponse
     */
    public function store(StoreLeadRequest $request): JsonResponse
    {
        $data = LeadData::fromRequest($request);
        $data->setLeadProviderId(LeadProvider::BETTER_CAR_PEOPLE);

        $lead = $this->service->createLead($data);

        LeadReceived::dispatch($lead);

        return response()->json($lead);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lead\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
