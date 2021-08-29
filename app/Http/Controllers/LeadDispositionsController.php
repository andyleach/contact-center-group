<?php

namespace App\Http\Controllers;

use App\Models\Team\LeadDisposition;
use App\Models\Team\LeadStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LeadDispositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('LeadDispositions/Index', [
            'leadDispositions' => LeadDisposition::query()
                ->where('team_id', auth()->user()->current_team_id)
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('LeadDispositions/Create', [
            'leadStatuses' => LeadStatus::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team\LeadDisposition  $leadDisposition
     * @return \Illuminate\Http\Response
     */
    public function show(LeadDisposition $leadDisposition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team\LeadDisposition  $leadDisposition
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadDisposition $leadDisposition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team\LeadDisposition  $leadDisposition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadDisposition $leadDisposition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team\LeadDisposition  $leadDisposition
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadDisposition $leadDisposition)
    {
        //
    }
}
