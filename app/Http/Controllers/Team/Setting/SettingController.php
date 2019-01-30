<?php

namespace App\Http\Controllers\Team\Setting;

use App\Http\Controllers\Controller;
use App\Team;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager');
    }

    public function index($teamName){
        $team = Team::where('name', $teamName)->first();
        return view('team.setting.index')
            ->withTeam($team);
    }
}
