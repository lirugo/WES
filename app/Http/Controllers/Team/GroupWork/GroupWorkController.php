<?php

namespace App\Http\Controllers\Team\GroupWork;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\GroupWork;
use App\Models\Team\GroupWorkFile;
use App\Models\Team\GroupWorkSubTeam;
use App\Models\Team\GroupWorkSubTeamMembers;
use App\Team;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function index($team){
        $team = Team::where('name', $team)->first();
        if(Auth::user()->hasRole('teacher'))
            $disciplines = Auth::user()->getTeacherDiscipline($team->name);
        else
            $disciplines = $team->disciplines;

        return view('team.group-work.index')
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function show($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();

        return view('team.group-work.show')
            ->withTeam($team)
            ->withDiscipline($discipline);
    }

    public function store(Request $request, $team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();

        $groupWork = GroupWork::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'teacher_id' => Auth::user()->id,
            'name' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date['time'].' 10:00:00',
            'end_date' => $request->end_date['time'].' 18:00:00',
        ]);

        foreach ($request['files'] as $file)
            GroupWorkFile::create([
                'group_work_id' => $groupWork->id,
                'file' => $file['file'],
                'name' => $file['name'],
                'type' => 'group-work',
            ]);

        $groupWork = GroupWork::with(['files'])->find($groupWork->id);
        return $groupWork;
    }

    public function storeFile(Request $request, $name)
    {
        if ($request->hasFile('file')) {
            $filePath = Storage::disk('group-work')->put('/', $request->file);
            return basename($filePath);
        } else
            return false;

    }

    public function getFile($name){
        $file = GroupWorkFile::where('file', $name)->first();
        $path = storage_path('/app/group-work/'.$name);
        $info = pathinfo($path);

        return response()->download($path, $file->name.'.'.$info['extension']);
    }

    public function getGroupWorks($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $groupWorks = GroupWork::with(['files'])->where([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
        ])->orderBy('id', 'DESC')->get();

        return $groupWorks;
    }

    public function subteams($team, $discipline, $groupWorkId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $groupWork = GroupWork::with(['files'])->find($groupWorkId);
        return view('team.group-work.subteams')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withGroupWork($groupWork);
    }

    public function storeSubTeam(Request $request, $team, $discipline, $groupWorkId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $groupWork = GroupWork::with(['files'])->find($groupWorkId);

        //Persist sub team
        $subTeam = GroupWorkSubTeam::create([
            'group_work_id' => $groupWork->id,
            'name' => $request->name,
        ]);

        //Add members
        foreach ($request->members as $member)
            GroupWorkSubTeamMembers::create([
                'subteam_id' => $subTeam->id,
                'user_id' => $member['id']
            ]);

        $subTeam = GroupWorkSubTeam::with('members')->find($subTeam->id);
        return $subTeam;
    }

    public function getSubTeams($team, $discipline, $groupWorkId){
        return GroupWorkSubTeam::with('members')->where('group_work_id', $groupWorkId)->get();
    }

}
