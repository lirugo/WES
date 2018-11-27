<?php

namespace App\Http\Controllers\Team\Pretest;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\Pretest;
use App\Models\Team\PretestAnswer;
use App\Models\Team\PretestFile;
use App\Models\Team\PretestQuestion;
use App\Team;
use DateTime;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PretestController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function index($team)
    {
        $team = Team::where('name', $team)->first();
        return view('team.pretest.index')
            ->withTeam($team);
    }

    public function create($team)
    {
        $team = Team::where('name', $team)->first();
        return view('team.pretest.create')
            ->withTeam($team);
    }

    public function store(Request $request, $name)
    {
        $team = Team::where('name', $name)->first();
        $discipline = Discipline::find($request->discipline_id);

        $pretest = Pretest::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'name' => $request->name,
            'description' => $request->description,
            'mark_in_journal' => $request->mark_in_journal == 'on' ? true : false,
            'time' => $request->time,
            'start_date' => new DateTime($request->start_date.' '.$request->start_time),
            'end_date' => new DateTime($request->start_date.' '.$request->start_time),
        ]);
        PretestFile::create([
            'pretest_id' => $pretest->id,
            'name' => $request->file,
            'file' => $request->nameFormServer,
        ]);

        Session::flash('success', 'Pretest was be successfully created');
        return redirect(url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id));
    }

    public function storeFile(Request $request, $name)
    {
        if ($request->hasFile('file')) {
            $filePath = Storage::disk('pretest')->put('/', $request->file);
            return basename($filePath);
        } else
            return false;

    }

    public function show($team, $discipline, $pretestId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $pretest = Pretest::find($pretestId);
        return view('team.pretest.show')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withPretest($pretest);
    }

    public function pretests($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $pretests = $team->getDiscipline($discipline->id)->pretests;
        return view('team.pretest.pretests')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withPretests($pretests);
    }

    public function getFile($name){
        $file = PretestFile::where('file', $name)->first();
        $path = storage_path('/app/pretest/'.$name);
        $info = pathinfo($path);

        return response()->download($path, $file->name.'.'.$info['extension']);
    }

    public function putQuestion(Request $request, $team, $discipline, $pretestId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $pretest = Pretest::find($pretestId);

        $question = PretestQuestion::create([
            'pretest_id' => $pretest->id,
            'name' => $request->name,
        ]);

        foreach($request->answers as $ans){
            PretestAnswer::create([
                'pretest_question_id' => $question->id,
                'name' => $ans['answer'],
                'is_answer' => $ans['isTrue']
            ]);
        }

        return PretestQuestion::with('answers')->find($question->id);
    }

    public function getQuestion($team, $discipline, $pretestId){
        $pretest = Pretest::find($pretestId);
        $questions = PretestQuestion::where('pretest_id', $pretest->id)->with('answers')->orderBy('id', 'DESC')->get();

        return $questions;
    }

    public function deleteQuestion($team, $discipline, $pretestId, $questionId){
        return PretestQuestion::destroy($questionId);
    }

    public function pass($team, $discipline, $pretestId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $pretest = Pretest::find($pretestId);

        return view('team.pretest.pass')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withPretest($pretest);
    }

}
