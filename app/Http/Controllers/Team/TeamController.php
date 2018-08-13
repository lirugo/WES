<?php

namespace App\Http\Controllers\Team;

use App\Http\Requests\StoreTeam;
use App\Permission;
use App\Role;
use App\Team;
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
        return view('team.create');
    }

    public function store(StoreTeam $request){
        // Persist
        $team = Team::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

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

        // Get all students
        $students = User::whereRoleIs('student')->get();

        // Get all teachers
        $teachers = User::whereRoleIs('teacher')->get();

        // Render View
        return view('team.edit')->withTeam($team)->withStudents($students)->withTeachers($teachers);
    }
}
