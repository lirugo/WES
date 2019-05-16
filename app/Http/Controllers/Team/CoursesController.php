<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Models\Team\GroupWork;
use App\Team;
use App\TeamDiscipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{
    public function disciplines($team){
        $team = Team::where('name', $team)->first();
        $disciplines = $team->disciplines;

        return view('team.courses.disciplines')
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function course($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $teamDiscipline = TeamDiscipline::
            where('team_id', $team->id)
            ->where('discipline_id', $discipline->id)->first();
        $groupWorks = GroupWork::with(['files'])->where([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
        ])->orderBy('id', 'DESC')->get();

        return view('team.courses.course')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withTeamDiscipline($teamDiscipline)
            ->withGroupWorks($groupWorks);
    }
}
