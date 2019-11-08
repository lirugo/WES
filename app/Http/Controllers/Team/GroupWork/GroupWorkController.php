<?php

namespace App\Http\Controllers\Team\GroupWork;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\GroupWork;
use App\Models\Team\GroupWorkFile;
use App\Models\Team\GroupWorkSubTeam;
use App\Models\Team\GroupWorkSubTeamChat;
use App\Models\Team\GroupWorkSubTeamDeadline;
use App\Models\Team\GroupWorkSubTeamMembers;
use App\Notifications\Team\NotifNewGroupWork;
use App\Team;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

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
            'start_date' => $request->start_date['time'].' 00:00:00',
            'end_date' => $request->end_date['time'].' 00:00:00',
        ]);

        foreach ($request['files'] as $file)
            GroupWorkFile::create([
                'group_work_id' => $groupWork->id,
                'file' => $file['file'],
                'name' => str_replace(['/', '\\'], [' ', ' '], $file['name']),
                'type' => 'group-work',
            ]);

        //Send notification
        try {
            foreach ($team->getStudents() as $member) {
                $member->notify(new NotifNewGroupWork($groupWork, $member));
            }
            $team->getOwner()->notify(new NotifNewGroupWork($groupWork, $team->getOwner()));
        } catch (\Exception $e) {
        }

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

        $students = [];
        foreach ($team->getStudents() as $student){
            $student->getTitle = $student->getShortName().' '.$student->jobs[0]->name.' '.$student->jobs[0]->position.' '.$student->jobs[0]->experience.' years';
            array_push($students, $student);
        }

        $subteams = GroupWorkSubTeam::with('members')->where('group_work_id', $groupWorkId)->get();
        foreach($subteams as $subteam){
            foreach($subteam->members as $member){
                foreach($students as $student){
                    if($student->id == $member->user_id){
                        if (($key = array_search($student, $students)) !== false) {
                            unset($students[$key]);
                        }
                    }
                }
            }
        }

        $studentsNew = [];
        foreach ($students as $student){
            $student->getName = $student->getShortName();
            array_push($studentsNew, $student);
        }

        return view('team.group-work.subteams')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withGroupWork($groupWork)
            ->withStudents($studentsNew);
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

    public function showSubTeam($team, $discipline, $groupWorkId, $subTeamId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $groupWork = GroupWork::with(['files'])->find($groupWorkId);
        $subTeam = GroupWorkSubTeam::find($subTeamId);

        //Close access for student if he is not a member
        if(Auth::user()->hasRole('student')){
            $inc = false;
            foreach($subTeam->members as $member){
                if(Auth::user()->id == $member->user_id)
                    $inc = true;
            }
            if(!$inc)
                abort(403);
        }

        return view('team.group-work.subteam')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withGroupWork($groupWork)
            ->withSubTeam($subTeam);
    }

    public function getMessages($team, $discipline, $groupWorkId, $subTeamId){
        $messages = GroupWorkSubTeamChat::with('author', 'files')->where('subteam_id', $subTeamId)->get();

        return $messages;
    }

    public function delete($team, $dicipline, $groupWorkId){
        $work = GroupWork::find($groupWorkId);
        $work->delete();
        Session::flash('success', 'Deleted');
        return back();
    }

    public function newMessage(Request $request, $team, $discipline, $groupWorkId, $subTeamId){
        $message = GroupWorkSubTeamChat::create([
            'subteam_id' => $subTeamId,
            'user_id' => Auth::user()->id,
            'text' => $request->text
        ]);

        foreach ($request['files'] as $file)
            GroupWorkFile::create([
                'chat_id' => $message->id,
                'file' => $file['file'],
                'name' => str_replace(['/', '\\'], [' ', ' '], $file['name']),
                'type' => 'sub-team',
            ]);

        $message = GroupWorkSubTeamChat::with('author', 'files')->find($message->id);
        return $message;
    }

    public function setSubTeamDeadline(Request $request, $team, $discipline, $groupWorkId, $subTeamId){
        return 'usus';
    }

    public function updateSubTeam(Request $request, $team, $discipline, $groupWorkId, $subTeamId){
        //Find existing deadline
        $deadline = GroupWorkSubTeamDeadline::where('subteam_id', $subTeamId)->first();
        //Or create new deadline
        if($deadline == null) {
            $deadline = new GroupWorkSubTeamDeadline();
            $deadline->subteam_id = $subTeamId;
        }

        $deadline->start_date = $request->start_date.' 00:00:00';
        $deadline->end_date = $request->end_date.' 00:00:00';
        $deadline->save();

        Session::flash('success', 'Sub Tean was updated');
        return back();

    }

    public function updateGroupWork(Request $request, $team, $discipline, $groupWorkId){
        $groupWork = GroupWork::find($groupWorkId);

        $groupWork->start_date = $request->start_date.' 00:00:00';
        $groupWork->end_date = $request->end_date.' 00:00:00';
        $groupWork->save();

        Session::flash('success', 'Group Work was updated');
        return back();

    }

    public function removeMember($team, $discipline, $groupWorkId, $subTeamId, $memberId){
        GroupWorkSubTeamMembers::where([
            'subteam_id' => $subTeamId,
            'user_id' => $memberId,
        ])->delete();
    }

    public function newSubTeamMember($team, $discipline, $groupWorkId, $subTeamId, $memberId){
        $user = User::find($memberId);

        //Check on duplicate
        if((count(GroupWorkSubTeamMembers::where([
                'subteam_id' => $subTeamId,
                'user_id' => $memberId,
            ])->get())) != 0)
            return 'duplicate';

        $member = GroupWorkSubTeamMembers::create([
            'subteam_id' => $subTeamId,
            'user_id' => $memberId,
        ]);
        $member = GroupWorkSubTeamMembers::with('user')->find($member->id);
        return $member;
    }

    public function subTeamUpdateMark(Request $request, $team, $discipline, $groupWorkId, $subTeamId, $memberId){
        $member = GroupWorkSubTeamMembers::where([
            'subteam_id' => $subTeamId,
            'user_id' => $memberId
        ])->first();
        $member->mark = $request->mark;
        $member->save();
        return $member;

    }

    public function finishGroupWork($team, $discipline, $groupWorkId){
        $groupWork = GroupWork::find($groupWorkId);

        $groupWork->finished = true;
        $groupWork->save();

        Session::flash('success', 'Group Work was be closed');
        return back();
    }

    public function finishSubTeam($team, $discipline, $groupWorkId, $subTeamId){
        $subTeam = GroupWorkSubTeam::find($subTeamId);
        $subTeam->finished = true;
        $subTeam->save();

        Session::flash('success', 'Sub Team was be closed');
        return back();
    }
}
