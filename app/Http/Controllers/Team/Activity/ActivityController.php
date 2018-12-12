<?php

namespace App\Http\Controllers\Team\Activity;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\TeamActivity;
use App\Models\Team\TeamActivityFile;
use App\Team;
use Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use DateTime;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher');
    }

    public function index($team){
        $team = Team::where('name', $team)->first();
        if(Auth::user()->hasRole('teacher'))
            $disciplines = Auth::user()->getTeacherDiscipline($team->name);
        else
            $disciplines = $team->disciplines;

        return view('team.activity.index')
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function create($team){
        $team = Team::where('name', $team)->first();
        return view('team.activity.create')
            ->withTeam($team);
    }

    public function store(Request $request, $team) {
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::find($request->discipline_id);
        $activity = TeamActivity::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'type_name' => $request->type == 'other' ? $request->type_name : null,
            'type' => $request->type,
            'mark_in_journal' => $request->mark_in_journal ? true : false,
            'max_mark' => $request->max_mark,
            'start_date' => new DateTime($request->start_date.' '.$request->start_time),
            'end_date' => new DateTime($request->end_date.' '.$request->end_time),
        ]);

        foreach (json_decode($request->inputs) as $file)
            if($file->nameFormServer != null)
                TeamActivityFile::create([
                    'activity_id' => $activity->id,
                    'name' => $file->file,
                    'file' => $file->nameFormServer,
                ]);

        Session::flash('success', 'Activity was be successfully created');
        return redirect(url('/team/'.$team->name.'/activity'));
    }

    public function storeFile(Request $request, $name)
    {
        if ($request->hasFile('file')) {
            $filePath = Storage::disk('activity')->put('/', $request->file);
            return basename($filePath);
        } else
            return false;

    }
}
