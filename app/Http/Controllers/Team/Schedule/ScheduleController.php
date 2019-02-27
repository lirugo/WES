<?php

namespace App\Http\Controllers\Team\Schedule;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\TeamLessonTime;
use App\Schedule;
use App\ScheduleTool;
use App\Team;
use App\TeamDiscipline;
use App\User;
use Auth;
use Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function index($name){
        $team = Team::where('name', $name)->first();

        $events = [];
        $schedules = $team->getSchedule();
        foreach ($schedules as $schedule) {
            $startDate =  Carbon::parse($schedule->start_date);
            $endDate =  Carbon::parse($schedule->end_date);
            $events[] = (object) [
                'title' => $schedule->title,
                'date' => $startDate->format('Y-m-d'),
                'start_time' => $startDate->format('H:m'),
                'end_time' => $endDate->format('H:m'),
                'duration' => Carbon::parse($startDate->format('Y-m-d H:m'))->diffInMinutes($endDate->format('Y-m-d H:m')),
                'tools' => $schedule->getTools(),
                'open' => false,
            ];
        }

        // Get all teachers
        $teachers = User::whereRoleIs('teacher')->get();
        // Get all discipline
        $disciplines = Discipline::all();

        return view('team.schedule.index')
            ->withEvents($events)
            ->withTeachers($teachers)
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function create($teamName){

        $team = Team::where('name', $teamName)->first();

        return view('team.schedule.create')
            ->withTeam($team);
    }

    public function store(Request $request, $name){
        //Validate
        $request->validate([
            'start_date' => 'required|date|after:today',
        ]);

        // Convert date
        $lesson = TeamLessonTime::find($request->lesson);
        $start = Carbon::parse(date('Y-m-d H:i', strtotime("$request->start_date, $lesson->start_time")));
        $end = Carbon::parse(date('Y-m-d H:i', strtotime("$request->start_date, $lesson->end_time")));

        // Check time is free
        $less = Schedule::where('start_date', $start)->count();
        if($less > 0){
            return back()->withErrors('That time is busy. Select another lecture');
        }

        // Find team
        $team = Team::where('name', $name)->first();

        // Find teacher
        $teacher = User::find($request->teacher_id);

        // Find Discipline
        $discipline = Discipline::find($request->discipline_id);
        // Get Discipline for specific team
        $teamDiscipline = TeamDiscipline::where([
            'team_id' => $team->id,
            'teacher_id' => $teacher->id,
            'discipline_id' => $discipline->id,
        ])->first();

        // Check teacher have free hours
        if($teamDiscipline->leftHours($team->id, $teacher->id, $discipline->id) <= 0){
            return back()->withErrors('Teacher dont have free hours');
        }

        $schdeule = Schedule::create([
                'team_id' => $team->id,
                'teacher_id' => $request->teacher_id,
                'discipline_id' => $request->discipline_id,
                'title' => 'Lecture '.$lesson->position.' '.$discipline->display_name.' '.$request->description,
                'start_date' => $start,
                'end_date' => $end,
            ]);

        //Set tools for lecture
        foreach ($request->tools as $tool)
            ScheduleTool::create([
                'schedule_id' => $schdeule->id,
                'title' => $tool,
            ]);

        // Flash msg
        Session::flash('success', 'Schedule was updated.');

        // Redirect back
        return redirect(url('/team/'.$team->name.'/schedule'));
    }

    public function delete($teamName, $scheduleId){
        // Find team
        $team = Team::where('name', $teamName)->first();

        // Remove
        Schedule::find($scheduleId)->delete();

        // Flash msg
        Session::flash('success', 'Schedule was successfully deleted.');

        // Redirect back
        return redirect(url('/team/'.$team->name.'/schedule'));

    }

    public function pdf($teamName){
        $team = Team::where('name', $teamName)->first();
        $data = ['schedules' => $team->schedules];
        $pdf = PDF::loadView('team.schedule.schedulePDF', $data);

        return $pdf->download('Schedule '.$team->display_name.'.pdf');
    }
}
