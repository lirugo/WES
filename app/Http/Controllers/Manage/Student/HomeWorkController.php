<?php

namespace App\Http\Controllers\Manage\Student;

use App\Discipline;
use App\Http\Requests\StoreHomeWork;
use App\Http\Requests\StoreHomeWorkSolution;
use App\Team;
use App\TeamsHomeWork;
use App\TeamsHomeWorkFile;
use App\TeamsHomeWorkSolution;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Session;
use Auth;


class HomeWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($team)
    {
        $team = Team::where('name', $team)->first();
        return view('manage.student.team.homework.index')
            ->withTeam($team);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(){
       //
    }

    public function solution(StoreHomeWorkSolution $request, $team, $discipline, $homeWork){
        // Get team
        $team = Team::where('name',$team)->first();

        // Get discipline
        $discipline = Discipline::where('name', $discipline)->first();

        // Get HomeWork
        $homeWork = TeamsHomeWork::where('name', $homeWork)->first();

        // Persist to db
        $solution = TeamsHomeWorkSolution::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'homework_id' => $homeWork->id,
            'student_id' => Auth::user()->id,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        // Save attachment if exists
        if($request->hasFile('file'))
        {
            foreach ($request->file as $f) {
                $filePath = Storage::disk('homework')->put('/task', $f);
                TeamsHomeWorkFile::create([
                    'team_id' => $team->id,
                    'homework_id' => $homeWork->id,
                    'student_id' => Auth::user()->id,
                    'status' => 'solution',
                    'name' => basename($filePath),
                ]);
            }
        }

        // Flash msg
        Session::flash('success', 'You solution was successfully added.');

        // Redirect back
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($team, $discipline)
    {
        $team = Team::where('name', $team)->first();

        $discipline = Discipline::where('name', $discipline)->first();

        return view('manage.student.team.homework.show')
            ->withTeam($team)
            ->withDiscipline($team->getDiscipline($discipline->id));
    }

    public function homework($team, $discipline, $homeWork){
        // Get Team
        $team = Team::where('name', $team)->first();

        // Get Discipline
        $discipline = Discipline::where('name', $discipline)->first();

        // Get HomeWork
        $homeWork = TeamsHomeWork::where('name', $homeWork)->first();

        return view('manage.student.team.homework.homework')
            ->withDiscipline($team->getDiscipline($discipline->id))
            ->withTeam($team)
            ->withHomeWork($homeWork);
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
