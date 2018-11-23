<?php

namespace App\Http\Controllers\Team\Pretest;

use App\Http\Controllers\Controller;
use App\Team;

class PretestController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function index($name){
        $team = Team::where('name', $name)->first();
        return view('team.pretest.index')
            ->withTeam($team);
    }

    public function create($name){
        $team = Team::where('name', $name)->first();
        return view('team.pretest.create')
            ->withTeam($team);
    }
}
