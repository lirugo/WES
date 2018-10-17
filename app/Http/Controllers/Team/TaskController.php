<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Http\Requests\StoreTask;
use App\Team;
use App\TeamTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher');
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($name, $discipline)
    {
        // Get Team
        $team = Team::where('name', $name)->first();
        // Get Discipline
        $discipline = Discipline::where('name', $discipline)->first();
        return view('team.mark.task.create')->with([
            'team' => $team,
            'discipline' => $team->getDiscipline($discipline->id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request, $team, $discipline)
    {
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        TeamTask::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'homework_id' => $request->homework_id,
            'number' => $request->number,
            'name' => $request->name,
            'description' => $request->description,
            'max_mark' => $request->max_mark,
            'has_term' => $request->has_term ? '1' : '0',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        Session::flash('success', 'Task was successfully created');
        return back();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
