<?php

namespace App\Http\Controllers\Team\VideoLesson;

use App\Discipline;
use App\Models\Team\GroupWork;
use App\Team;
use App\TeamDiscipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoLessonController extends Controller
{
    public function disciplines($team){
        $team = Team::where('name', $team)->first();
        $disciplines = $team->disciplines;

        return view('team.videoLesson.disciplines')
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function index($teamName, $teamDisciplineId){
        $teamDiscipline = TeamDiscipline::where('id', $teamDisciplineId)->first();
        $team = $teamDiscipline->team;
        $discipline = $teamDiscipline->getDiscipline();
        $videoLessons = [];

        return view('team.videoLesson.index')
            ->withTeam($team)
            ->withTeamDiscipline($teamDiscipline)
            ->withDiscipline($discipline)
            ->withVideoLessons($videoLessons);
    }

}
