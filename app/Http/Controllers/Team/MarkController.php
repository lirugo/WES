<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Models\Team\TeamActivity;
use App\Team;
use App\TeamDiscipline;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class MarkController extends Controller
{
    private function unique_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    /**
     * Display a common journal.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        $common = [];
        // Get Team
        $team = Team::where('name', $name)->first();
        // Get Students
        $students = $team->getStudents();
        // Get all disciplines
        $disciplines = $team->disciplines;

        //Validate access for user role
        if(Auth::user()->hasRole('teacher')){
            $disciplines = $team->getDisciplines(Auth::user()->id);
        } else if(Auth::user()->hasRole('student')){
            $students = new Collection();
            $students->push(Auth::user());
        }

        //Processing common data
        foreach ($disciplines as $disc){
            foreach ($students as $student){
                //Mark for a discipline
                $discMark = 0;
                foreach ($disc->getActivities as $act){
                    //If mark in journal
                    if($act->mark_in_journal){
                        $discMark += $act->getMark($student->id) ? $act->getMark($student->id)->mark : 0;
                    }
                }

                $common[] =  [
                    'discipline' => $disc->getDiscipline->display_name,
                    'disciplineName' => $disc->getDiscipline->name,
                    'student' => $student->getShortName(),
                    'mark' => $discMark
                ];
            }
        }

        // Common example
        // 0 => [
        //    "discipline" => "Деловые и кросс-культурные коммуникации"
        //    "disciplineName" => "delovye-i-kross-kulturnye-kommunikacii"
        //    "student" => "Bondar R."
        //    "mark" => 22
        //  ]

        // Return view
        return view('team.mark.common')->with([
            'common' => $common,
            'commonStudents' => $this->unique_array($common, 'student'),
            'commonDisciplines' => $this->unique_array($common, 'discipline'),
            'team' => $team,
            'disciplines' => $team->getDisciplines(Auth::user()->id)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function discipline($name, $discipline)
    {
        $common = [];
        // Get Team
        $team = Team::where('name', $name)->first();
        // Get Discipline
        $discipline = Discipline::where('name', $discipline)->first();
        // Get Activities
        $activities = TeamActivity::where([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id
        ])->get();

        // Get Students
        $students = $team->getStudents();
        if(Auth::user()->hasRole('student')){
            $students = new Collection();
            $students->push(Auth::user());
        }
        // Processing common data
        foreach ($students as $student){
            foreach ($activities as $act){
                $common[] = [
                    'student' => $student->getShortName(),
                    'studentId' => $student->id,
                    'activityId' => $act->id,
                    'activityName' => $act->name,
                    'actDate' => Carbon::parse($act->start_date)->format('d-m-Y'),
                    'mark' => $act->getMark($student->id) ? $act->getMark($student->id)->mark : 0,
                ];
            }
        }

        // Common example
        // 0 => [
        //    "student" => "Bondar R."
        //    "studentId" => 37
        //    "activityId" => 4
        //    "activityName" => 37
        //    "actDate" => "25-01-2019"
        //    "mark" => 22
        // ]

        if(empty($common)){
            return back()->withErrors('Dont have any activity for that discipline yet...');
        }

        // Return view
        return view('team.mark.discipline')->with([
            'common' => $common,
            'commonStudents' => $this->unique_array($common, 'student'),
            'commonActDates' => $this->unique_array($common, 'actDate'),
            'team' => $team,
            'discipline' => $discipline
        ]);
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
