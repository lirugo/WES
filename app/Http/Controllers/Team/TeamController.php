<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Http\Requests\StoreTeam;
use App\Permission;
use App\Role;
use App\Team;
use App\TeamDiscipline;
use App\TeamTemplate;
use App\User;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;
use Auth;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager');
    }

    public function index(){
        $teams = Team::all();
        return view('team.index')->withTeams($teams);
    }

    public function create(){
        $templates = TeamTemplate::all();
        return view('team.create')
            ->withTemplates($templates);
    }

    public function store(StoreTeam $request){
        // Get Template
        $template = TeamTemplate::where('name', $request->template)->first();

        // Persist
        $team = Team::create([
            'name' => $template->name.'-'.$request->name,
            'display_name' => $template->display_name.'-'.$request->display_name,
            'description' => $request->description,
        ]);

        foreach($template->disciplines as $discipline){
            // Find teacher
            $user = User::find($discipline->teacher_id);

            // Find role teacher
            $teacher = Role::where('name', 'teacher')->first();

            // Get ACL permission for teacher
            $readAcl = Permission::where('name', 'read-acl')->first();
            $updateAcl = Permission::where('name', 'update-acl')->first();

            // Attach permission for student to team
            $user->attachPermissions([$readAcl,$updateAcl], $team);
            $user->attachRole($teacher, $team);

            // Add discipline to team
            TeamDiscipline::create([
                'team_id' => $team->id,
                'teacher_id' => $user->id,
                'discipline_id' => $discipline->id,
            ]);
        }

        // Get ACL permission for manager
        $ownerGroup = Role::where('name', 'owner')->first();
        $createAcl = Permission::where('name', 'create-acl')->first();
        $readAcl = Permission::where('name', 'read-acl')->first();
        $updateAcl = Permission::where('name', 'update-acl')->first();

        // Attach manager to new team
        Auth::user()->attachRole($ownerGroup, $team);
        Auth::user()->attachPermissions([$createAcl,$readAcl,$updateAcl], $team);

        // Show flash msg
        Session::flash('success', 'Team was successfully created. You owner this team');

        // Return to manage
        return redirect(url('/team'));
    }

    public function show($name){
        $team = Team::where('name', $name)->first();
        return view('team.show')->withTeam($team);
    }

    public function edit($name){
        // Get Team
        $team = Team::where('name', $name)->first();

        // Get all students not in the current group
        $students = User::whereRoleIs('student')->with('rolesTeams')->get();
        foreach ($students as $sk => $student){
            foreach($student->rolesTeams as $key => $t){
                if($t->id == $team->id)
                    $students->forget($sk);
            }
        }

        // Get all teachers
        $teachers = User::whereRoleIs('teacher')->get();

        // Get all disciplines
        $disciplines = Discipline::all();

        // Render View
        return view('team.edit')
            ->withTeam($team)
            ->withStudents($students)
            ->withTeachers($teachers)
            ->withDisciplines($disciplines);
    }
}
