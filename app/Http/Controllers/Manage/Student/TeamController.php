<?php

namespace App\Http\Controllers\Manage\Student;

use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:student');
    }

    public function show($name){
        $team = Team::where('name', $name)->first();
        return view('team.show')->withTeam($team);
    }

    public function schedule($name){
        $team = Team::where('name', $name)->first();
        return view('manage.student.team.schedule')->withTeam($team);
    }

    public function teachers($name){
        $team = Team::where('name', $name)->first();
        return view('manage.student.team.teachers')->withTeam($team);
    }

}
