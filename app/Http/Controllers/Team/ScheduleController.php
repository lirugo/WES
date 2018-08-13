<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Http\Requests\StoreSchedule;
use App\Schedule;
use App\Team;
use App\User;
use Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager');
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

        return view('team.schedule')
            ->withCalendar($calendar)
            ->withTeachers($teachers)
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function store(StoreSchedule $request, $name){
        // Convert date
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $start_date = Carbon::parse(date('Y-m-d H:i', strtotime("$request->start_date, $request->start_time")));
        $end_date = Carbon::parse(date('Y-m-d H:i', strtotime("$request->start_date, $request->end_time")));

        // Find team
        $team = Team::where('name', $name)->first();

        while($start <= $end)
        {
            // Persist to db
            Schedule::create([
                'team_id' => $team->id,
                'teacher_id' => $request->teacher_id,
                'discipline_id' => $request->discipline_id,
                'title' => $request->title,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
            // Add next day
            $start = $start->addDay();
            $start_date = $start_date->addDay();
            $end_date = $end_date->addDay();
        }

        // Flash msg
        Session::flash('success', 'Schedule was updated.');

        // Redirect back
        return back();
    }
}
