<?php

namespace App\Http\Controllers\Team\GroupWork;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\GroupWork;
use App\Team;
use Auth;
use DateTime;
use Illuminate\Http\Request;

class GroupWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function index($team){
        $team = Team::where('name', $team)->first();
        if(Auth::user()->hasRole('teacher'))
            $disciplines = Auth::user()->getTeacherDiscipline($team->name);
        else
            $disciplines = $team->disciplines;

        return view('team.group-work.index')
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function show($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();

        return view('team.group-work.show')
            ->withTeam($team)
            ->withDiscipline($discipline);
    }

    public function store(Request $request, $team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();

        $groupWork = GroupWork::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'teacher_id' => $request->teacher_id,
            'name' => $request->title,
            'description' => $request->description,
            'start_date' => new DateTime(),
            'end_date' => new DateTime(),
        ]);

        return $request->all();
    }

}
