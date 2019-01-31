<?php

namespace App\Http\Controllers\Team\Setting;

use App\Http\Controllers\Controller;
use App\Team;
use App\TeamDiscipline;
use Illuminate\Http\Request;

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

    public function disciplinesUpdate(Request $request, $teamName){
        $team = Team::where('name', $teamName)->first();
        $teamDisciplines = $request->all();

        //Validate

        //Updating
        foreach ($teamDisciplines as $disc){
            $teamDiscipline = TeamDiscipline::find($disc['id']);
            $teamDiscipline->hours = $disc['hours'];
            $teamDiscipline->disabled = $disc['disabled'] ? 1 : 0;
            $teamDiscipline->save();
        }

        return response($team->disciplines, 200);
    }
}
