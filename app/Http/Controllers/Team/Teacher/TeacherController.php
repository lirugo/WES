<?php

namespace App\Http\Controllers\Team\Teacher;

use App\Team;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        $team = Team::where('name', $name)->first();
        return view('team.teacher.index')
            ->withTeam($team);
    }
}
