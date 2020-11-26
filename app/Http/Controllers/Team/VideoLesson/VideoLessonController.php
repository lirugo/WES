<?php

namespace App\Http\Controllers\Team\VideoLesson;

use App\Http\Controllers\Controller;
use App\Models\Team\TeamVideoLesson;
use App\Team;
use App\TeamDiscipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

class VideoLessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function create($team){
        $team = Team::where('name', $team)->first();
        $disciplines = $team->disciplines;

        return view('team.videoLesson.create')
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function disciplines($team){
        $team = Team::where('name', $team)->first();
        $disciplines = $team->disciplines;

        return view('team.videoLesson.disciplines')
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function store(Request $request, $team){
        //Save file
        $filePath = Storage::disk('video-lesson')->put('/', $request->file);
        $fileName = basename($filePath);
        $team = Team::where('name', $team)->first();
        $teamDiscipline = TeamDiscipline::where('team_id', $team->id)->where('discipline_id', $request->discipline_id)->first();

        TeamVideoLesson::create([
            'owner_id' => auth()->id(),
            'team_discipline_id' => $teamDiscipline->id,
            'module' => $request->module,
            'part' => $request->part,
            'public' => $request->public ? true : false,
            'file_name' => $fileName,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => '',
        ]);

        Session::flash('success', 'Video lesson was be successfully created');
        return redirect(url('/team/'.$team->name.'/video-lesson'));
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

    public function delete($teamName, $videoLessonId){
        $videoLesson = TeamVideoLesson::where('id', $videoLessonId)->first();

        Storage::disk('video-lesson')->delete($videoLesson->file_name);
        $videoLesson->delete();

        Session::flash('success', 'Video lesson was be successfully deleted');
        return redirect()->back();
    }

}
