<?php

namespace App\Http\Controllers\Team\HomeWork;

use App\Discipline;
use App\Http\Requests\StoreHomeWork;
use App\Team;
use App\TeamDiscipline;
use App\TeamsHomeWork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HomeWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager');
    }

    public function show($team, $discipline){
        $team = Team::where('name', $team)->first();
        $dis = Discipline::where('name', $discipline)->first();
        $discipline = TeamDiscipline::where('team_id', $dis->id)->first();

        return view('team.homework.show')
            ->withDiscipline($discipline)
            ->withTeam($team);
    }

    public function store(StoreHomeWork $request, $team, $discipline){
        // Get team
        $team = Team::where('name',$team)->first();

        // Get discipline
        $discipline = Discipline::where('name', $discipline)->first();

        // Persist to db
        $homework = TeamsHomeWork::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'teacher_id' => Auth::user()->id,
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'assignment_date' => Carbon::parse(date('Y-m-d H:i', strtotime("$request->end_date, $request->end_time"))),
        ]);
        // Save file if exist
        if($request->hasFile('file'))
        {
            $filePath = Storage::disk('homework')->put('/task', $request->file);
            $homework->file =  basename($filePath);
            $homework->save();
        }

        // Flash message
        Session::flash('success', 'Homework was successfully added.');

        // Redirect back
        return back();
    }
}
