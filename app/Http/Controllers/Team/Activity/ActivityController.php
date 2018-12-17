<?php

namespace App\Http\Controllers\Team\Activity;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\TeamActivity;
use App\Models\Team\TeamActivityFile;
use App\Models\Team\TeamActivityReply;
use App\Team;
use App\User;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

class ActivityController extends Controller
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
            'teacher_id' => Auth::user()->id,
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

    public function show($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $activities = TeamActivity::where(
            ['team_id' => $team->id],
            ['discipline_id' => $discipline->id]
        )->orderBy('id', 'DESC')->get();

        return view('team.activity.show')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withActivities($activities);
    }

    public function storeFile(Request $request, $name)
    {
        if ($request->hasFile('file')) {
            $filePath = Storage::disk('activity')->put('/', $request->file);
            return basename($filePath);
        } else
            return false;

    }

    public function getFile($name){
        $file = TeamActivityFile::where('file', $name)->first();
        $path = storage_path('/app/activity/'.$name);
        $info = pathinfo($path);

        return response()->download($path, $file->name.'.'.$info['extension']);
    }

    public function pass($team, $discipline, $activityId, $studentId=null){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $activity = TeamActivity::find($activityId);
        if($studentId)
            $student = User::find($studentId);
        else
            $student = User::find(Auth::user()->id);
        if(!$activity->isOpen())
            abort(403);

        return view('team.activity.pass')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withStudent($student)
            ->withActivity($activity);
    }

    public function students($team, $discipline, $activityId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $activity = TeamActivity::find($activityId);

        return view('team.activity.students')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withActivity($activity);
    }

    //API Chat Functionality
    public function send(Request $request, $team, $activityId, $studentId){
        $message = TeamActivityReply::create([
            'teacher_id' => Auth::user()->hasRole('teacher') ? Auth::user()->id : null,
            'student_id' => $studentId,
            'activity_id' => $activityId,
            'text' => $request->text,
        ])->load('teacher');
        return $message;
    }

    public function getMessages($team, $activityId, $studentId){
        //Check access
        //Get messages
        $messages = TeamActivityReply::with('teacher')->where(
            ['student_id' => $studentId],
            ['activity_id' => $activityId]
        )->orderBy('id', 'DESC')->get();
        //Return messages
        return $messages;
    }
}
