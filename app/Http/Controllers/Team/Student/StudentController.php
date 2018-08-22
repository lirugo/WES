<?php

namespace App\Http\Controllers\Team\Student;

use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($team)
    {
        $team = Team::where('name', $team)->first();

        return view('team.student.index')
            ->withTeam($team);
    }


}
