<?php

namespace App\Http\Controllers\Team\Pretest;

use App\Charts\ChartPretestStatistic;
use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\Pretest;
use App\Models\Team\PretestAnswer;
use App\Models\Team\PretestFile;
use App\Models\Team\PretestQuestion;
use App\Models\Team\PretestUserAccess;
use App\Models\Team\PretestUserAnswer;
use App\Models\Team\TeamActivityMark;
use App\Notifications\Team\NotifNewPretest;
use App\Team;
use App\User;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
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

        if(Auth::user()->hasRole('teacher'))
            $disciplines = Auth::user()->getTeacherDiscipline($team->name);
        else
            $disciplines = $team->disciplines;

        return view('team.pretest.index')
            ->withTeam($team)
            ->withDisciplines($disciplines);
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
            'end_date' => new DateTime($request->end_date.' '.$request->end_time),
        ]);
        foreach (json_decode($request->inputs) as $file)
            PretestFile::create([
            'pretest_id' => $pretest->id,
            'name' => str_replace(['/', '\\'], [' ', ' '], $file->file),
            'file' => $file->nameFormServer,
        ]);

        //Send notification
        foreach ($team->getStudents() as $member){
            $member->notify(new NotifNewPretest($pretest, $member));
        }
        $team->getOwner()->notify(new NotifNewPretest($pretest, $team->getOwner()));

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
//        $access = 0;
//        foreach ($team->getTeachers() as $teacher){
//           if($teacher->id == Auth::user()->id)
//               $access++;
//        }
//        if($access == 0)
//           return back();

        return view('team.pretest.show')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withPretest($pretest);
    }

    public function pretests($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $pretests = $team->pretests($discipline->id)->get();

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

        //Store mark in journal
        TeamActivityMark::create([
            'type' => 'pretest',
            'student_id' => Auth::user()->id,
            'activity_id' => $pretestId,
            'mark' => $countAnswers
        ]);

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
        if(!Auth::user()->hasRole(['manager', 'teacher']))
            return back();

        //Get Data for Chart
        $chartData = new Collection();
        foreach ($pretest->questions as $question){
            $countAnswer = 0;
            foreach ($question->userAnswers as $answer){
                if($answer->isAnswer())
                    $countAnswer++;
            }
            $chartData->push((object) [
                'questionId' => $question->id,
                'countAnswers' => $countAnswer
            ]);
        }
        $labels = [];
        $data = [];
        foreach ($chartData as $key => $ch){
            array_push($labels, 'Question '.($key+1) );
            array_push($data, $ch->countAnswers);
        }

        //Chart
        $chart = new ChartPretestStatistic();
        $chart->labels($labels);
        $chart->dataset('Answers', 'bar', $data);


        //Statistics
        $pretest = Pretest::find($pretestId);

        $students = $team->getStudents();

        foreach ($students as $student){
            $countAnswers = 0;
            $passed = false;
            $questions = $pretest->questions;
            $quests = new Collection();
            foreach ($questions as $question){
                if(count($student->pretestAnswers) > 0)
                    $passed = true;
                $hasAnswer = false;
                foreach ($question->rightAnswers() as $answer){
                    foreach ($student->pretestAnswers as $studentAnswer) {
                        if ($studentAnswer->pretest_answer_id == $answer->id){
                            $hasAnswer = true;
                        }
                    }
                }
                if($hasAnswer)
                    $countAnswers++;
                $quests->push((object) ['questionId' => $question->id, 'hasAnswer' => $hasAnswer]);
            }
            $student->passed = $passed;
            $student->shortName = $student->getShortName();
            $student->countAnswers = $countAnswers;
            $student->questions = $quests;
        }
        return view('team.pretest.statistic')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withPretest($pretest)
            ->withChart($chart)
            ->withStudents($students);
    }

    public function getStatistic($team, $discipline, $pretestId){
        $team = Team::where('name', $team)->first();
        $pretest = Pretest::find($pretestId);

        $students = $team->getStudents();
        foreach ($students as $student){
            $countAnswers = 0;
            $passed = false;
            $questions = $pretest->questions;
            $quests = new Collection();
            foreach ($questions as $question){
                if(count($student->pretestAnswers) != 0)
                    $passed = true;
                $hasAnswer = false;
                foreach ($question->rightAnswers() as $answer){
                    foreach ($student->pretestAnswers as $studentAnswer) {
                        if ($studentAnswer->pretest_answer_id == $answer->id){
                            $hasAnswer = true;
                        }
                    }
                }
                if($hasAnswer)
                    $countAnswers++;
                $quests->push((object) ['questionId' => $question->id, 'hasAnswer' => $hasAnswer]);
            }
            $student->passed = $passed;
            $student->shortName = $student->getShortName();
            $student->countAnswers = $countAnswers;
            $student->questions = $quests;
        }

        return $students;
    }

    public function access($team, $discipline, $pretestId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $pretest = Pretest::find($pretestId);

        if(!Auth::user()->hasRole('manager')) {
            return back();
        }

        return view('team.pretest.access')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withPretest($pretest);
    }

    public function setAccess(Request $request, $team, $discipline, $pretestId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $pretest = Pretest::find($pretestId);

        //Delete deny access
        PretestUserAccess::where([
            ['user_id', $request->student_id],
            ['pretest_id', $pretest->id]
        ])->delete();

        //Delete old user answers
        foreach ($pretest->questions as $question)
            PretestUserAnswer::where([
                ['user_id', $request->student_id],
                ['pretest_question_id', $question->id]
            ])->delete();

        Session::flash('success', 'Access was be added');
        return back();
    }

    public function delete($team, $discipline, $pretestId) {
        if(!Auth::user()->hasRole('manager'))
            abort(403);
        Pretest::find($pretestId)->delete();
        Session::flash('success', 'Pretest has been successfully deleted');
        return back();

    }

    public function update(Request $request, $team, $discipline, $pretestId) {
        $pretest = Pretest::find($pretestId);
//        if($pretest->isEditable()) {
//            $pretest->time = $request->time;
//            $pretest->name = $request->name;
//            $pretest->description = $request->description;
            $pretest->start_date = new DateTime($request->start_date . ' ' . $request->start_time);
            $pretest->end_date = new DateTime($request->end_date . ' ' . $request->end_time);
//            $pretest->mark_in_journal = $request->mark_in_journal == 'on' ? true : false;
            $pretest->save();
            Session::flash('success', 'Pretest has been successfully updated');
//        }else Session::flash('errors', 'Deny');

        return back();
    }

    public function updateEndDate(Request $request, $team, $discipline, $pretestId) {
        $pretest = Pretest::find($pretestId);
        $pretest->end_date = new DateTime($request->end_date . ' ' . $request->end_time);
        $pretest->save();
        Session::flash('success', 'End date has been successfully updated');

        return back();
    }
}
