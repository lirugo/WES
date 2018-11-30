<?php

namespace App\Http\Controllers\Team\Pretest;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\Pretest;
use App\Models\Team\PretestAnswer;
use App\Models\Team\PretestFile;
use App\Models\Team\PretestQuestion;
use App\Models\Team\PretestUserAccess;
use App\Models\Team\PretestUserAnswer;
use App\Team;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Session;
use Auth;

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
        // TODO:: Remake checking Access
        $access = 0;
        foreach ($team->getTeachers() as $teacher){
           if($teacher->id == Auth::user()->id)
               $access++;
        }
        if($access == 0)
           return back();

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
        if(
            Auth::user()->hasRole('student') &&
            $pretest->isAvailable(Auth::user()->id)
        ){
            return view('team.pretest.pass')
                ->withTeam($team)
                ->withDiscipline($discipline)
                ->withPretest($pretest);
        }else {
            return back()->withErrors('Access denied. Contact to your manager');
        }
    }

    public function checking(Request $request, $team, $discipline, $pretestId){
        $pretest = Pretest::find($pretestId);
        $data = [];
        $countAnswers = 0;
        foreach($pretest->questions as $question) {
            foreach ($request->all() as $req) {
                if ($req['questionId'] == $question->id){
                    foreach ($req['answers'] as $ans){
                        PretestUserAnswer::create([
                            'user_id' => Auth::user()->id,
                            'pretest_question_id' => $req['questionId'],
                            'pretest_answer_id' => $ans,
                        ]);
                        if($pretest->isAnswer($req['questionId'], $ans)){
                            $countAnswers++;
                            break;
                        }
                    }
                }
            }
        }
        $data['countAnswers'] = $countAnswers;
        return $data;
    }

    public function startPretest($team, $discipline, $pretestId){
        PretestUserAccess::create([
            'user_id' => Auth::user()->id,
            'pretest_id' => $pretestId,
            'access' => false,
        ]);
        return ['status' => 'OK'];
    }

    public function available($team, $discipline, $pretestId){
        return Pretest::find($pretestId)->isAvailable(Auth::user()->id);
    }

    public function statistic($team, $discipline, $pretestId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $pretest = Pretest::find($pretestId);
        if(!Auth::user()->hasRole('teacher'))
            return back();

        return view('team.pretest.statistic')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withPretest($pretest);
    }

    public function getStatistic($team, $discipline, $pretestId){
        $team = Team::where('name', $team)->first();
        $pretest = Pretest::find($pretestId);

        $students = $team->getStudents();
        foreach ($students as $student){
            $countAnswers = 0;
            foreach ($pretest->questions as $question){
                $hasAnswer = false;
                foreach ($question->rightAnswers() as $answer){
                    foreach ($student->pretestAnswers as $studentAnswer) {
                        if ($studentAnswer->pretest_answer_id == $answer->id) {
                            $hasAnswer = true;
                        }
                    }
                }
                $question['has_answer'] = $hasAnswer;
                if($hasAnswer) {
                    $countAnswers++;
                }
            }
            $student['shortName'] = User::find($student->id)->getShortName();
            $student['countAnswers'] = $countAnswers;
            $student['questions'] = $pretest->questions;
        }

        return $students;
    }

}
