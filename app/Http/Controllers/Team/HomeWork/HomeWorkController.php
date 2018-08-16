<?php

namespace App\Http\Controllers\Team\HomeWork;

use App\Discipline;
use App\Http\Requests\StoreHomeWork;
use App\Http\Requests\StoreHomeWorkSolution;
use App\Team;
use App\TeamDiscipline;
use App\TeamsHomeWork;
use App\TeamsHomeWorkFile;
use App\TeamsHomeWorkSolution;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Auth;
use http\Env\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HomeWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager');
    }

    public function index($team){
        $team = Team::where('name', $team)->first();
        return view('team.homework.index')
            ->withDisciplines($team->disciplines)
            ->withTeam($team);
    }

    public function create($team, $discipline){
        $team = Team::where('name', $team)->first();
        $dis = Discipline::where('name', $discipline)->first();
        $discipline = TeamDiscipline::where('discipline_id', $dis->id)->first();

        return view('team.homework.create')
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
            foreach ($request->file as $f) {
                $filePath = Storage::disk('homework')->put('/task', $f);
                TeamsHomeWorkFile::create([
                    'team_id' => $team->id,
                    'homework_id' => $homework->id,
                    'status' => 'task',
                    'name' => basename($filePath),
                ]);
            }
        }

        // Flash message
        Session::flash('success', 'Homework was successfully added.');

        // Redirect back
        return back();
    }

    public function show($team, $discipline){
        // Get Team
        $team = Team::where('name', $team)->first();

        // Get Discipline
        $discipline = Discipline::where('name', $discipline)->first();

        return view('team.homework.show')
            ->withDiscipline($team->getDiscipline($discipline->id))
            ->withTeam($team);
    }

    // Return file for user if user is member group
    public function file($team, $discipline, $file)
    {
        $team = Team::where('name', $team)->first();
        if($team->isMember(Auth::user())){
            $path = storage_path('\app\group\homework\task\/'.$file);
            return response()->file($path);
        }

        abort(403);
    }

    public function homework($team, $discipline, $homeWork){
        // Get Team
        $team = Team::where('name', $team)->first();

        // Get Discipline
        $discipline = Discipline::where('name', $discipline)->first();

        // Get HomeWork
        $homeWork = TeamsHomeWork::where('name', $homeWork)->first();

        return view('team.homework.homework')
            ->withDiscipline($team->getDiscipline($discipline->id))
            ->withTeam($team)
            ->withHomeWork($homeWork);
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
}
