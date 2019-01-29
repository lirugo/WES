<?php

namespace App\Http\Controllers\Team\Schedule;

use App\Discipline;
use App\Http\Requests\StoreSchedule;
use App\Models\Team\TeamLessonTime;
use App\Schedule;
use App\ScheduleTool;
use App\Team;
use App\User;
use Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function index($name){
        $team = Team::where('name',$name)->first();

        $events = [];
        $schedules = $team->getSchedule();
        foreach ($schedules as $key => $value) {
            $events[] = Calendar::event(
                $value->title,
                false,
                new \DateTime($value->start_date),
                new \DateTime($value->end_date),
                null,
                [
                    'color' => '#3f51b5',
                ]
            );
        }
        $calendar = Calendar::addEvents($events)->setOptions([
            'firstDay' => 1,
            'timeFormat' => 'H:mm',
            'axisFormat' => 'H:mm',
        ]);

        // Get all teachers
        $teachers = User::whereRoleIs('teacher')->get();
        // Get all discipline
        $disciplines = Discipline::all();

        return view('team.schedule.index')
            ->withCalendar($calendar)
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
        // Convert date
        $lesson = TeamLessonTime::find($request->lesson);
        $start = Carbon::parse(date('Y-m-d H:i', strtotime("$request->start_date, $lesson->start_time")));
        $end = Carbon::parse(date('Y-m-d H:i', strtotime("$request->start_date, $lesson->end_time")));

        // Find team
        $team = Team::where('name', $name)->first();

        // Find teacher
        $teacher = User::find($request->teacher_id);

        // Find Discipline
        $discipline = Discipline::find($request->discipline_id);

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
}
