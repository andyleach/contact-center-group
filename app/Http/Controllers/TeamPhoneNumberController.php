<?php

namespace App\Http\Controllers;

use App\Models\Team\TeamPhoneNumber;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamPhoneNumberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team\TeamPhoneNumber  $teamPhoneNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamPhoneNumber $teamPhoneNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team\TeamPhoneNumber  $teamPhoneNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamPhoneNumber $teamPhoneNumber)
    {
        //
    }
}
