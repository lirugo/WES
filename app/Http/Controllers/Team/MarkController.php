<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Team;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $this->middleware('role:administrator|top-manager|manager|teacher');
    }

    /**
     * Display a common journal.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        // Get Team
        $team = Team::where('name', $name)->first();
        // Get Students
        $students = $team->getStudents();
        // Get all disciplines
        $disciplines = $team->disciplines;

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
                    'student' => $student->getShortName(),
                    'studentId' => $student->id,
                    'mark' => $discMark
                ];
            }
        }

        // Common example
        // 0 => [
        //    "discipline" => "Деловые и кросс-культурные коммуникации"
        //    "studentId" => 37
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
    public function student($name, $studentId)
    {
        // Get Team
        $team = Team::where('name', $name)->first();
        // Get Student
        $student = User::find($studentId);

        return view('team.mark.student')->with([
            'team' => $team,
            'student' => $student
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
