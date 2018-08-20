<?php

namespace App\Http\Controllers\Manage\Student;

use App\Schedule;
use App\Team;
use Calendar;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:student');
    }

    public function index($name)
    {
        $team = Team::where('name',$name)->first();

        $events = [];
        $data = $team->getSchedule();
        foreach ($data as $key => $value) {
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
        return view('manage.student.team.schedule')
            ->withCalendar($calendar)
            ->withTeam($team);
    }
}
