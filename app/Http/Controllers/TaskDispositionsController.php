<?php

namespace App\Http\Controllers;

use App\Models\Team\LeadDisposition;
use App\Models\Team\TaskDisposition;
use App\Models\System\TaskStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskDispositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('TaskDispositions/Index', [
            'taskDispositions' => LeadDisposition::query()
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
        return Inertia::render('TaskDispositions/Create', [
            'taskStatuses' => TaskStatus::all()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team\TaskDisposition  $taskDisposition
     * @return \Illuminate\Http\Response
     */
    public function show(TaskDisposition $taskDisposition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team\TaskDisposition  $taskDisposition
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskDisposition $taskDisposition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team\TaskDisposition  $taskDisposition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskDisposition $taskDisposition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team\TaskDisposition  $taskDisposition
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskDisposition $taskDisposition)
    {
        //
    }
}
