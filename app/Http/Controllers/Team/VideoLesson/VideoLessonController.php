<?php

namespace App\Http\Controllers\Team\VideoLesson;

use App\Http\Controllers\Controller;
use App\Team;
use App\TeamDiscipline;

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
        $videoLessons = $teamDiscipline->getVideoLessons()->get();

        return view('team.videoLesson.index')
            ->withTeam($team)
            ->withTeamDiscipline($teamDiscipline)
            ->withDiscipline($discipline)
            ->withVideoLessons($videoLessons);
    }

}
