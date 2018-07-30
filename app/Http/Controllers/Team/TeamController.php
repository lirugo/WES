<?php

namespace App\Http\Controllers\Team;

use App\Http\Requests\StoreGroup;
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
        $this->middleware('auth');
    }

    public function index(){
        $teams = Team::all();
        return view('team.index')->withTeams($teams);
    }

    public function create(){
        return view('team.create');
    }

    public function store(StoreGroup $request){
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

    public function show($id){
        $team = Team::find($id);
        return view('team.show')->withTeam($team);
    }

    public function edit($id){
        // Get Team
        $team = Team::find($id);

        // Get all students
        $students = User::whereRoleIs('student')->get();

        // Render View
        return view('team.edit')->withTeam($team)->withStudents($students);
    }

    public function addMember(Request $request, $teamId){
        // Validate access

        // Find user
        $user = User::find($request->member);

        // Find team
        $team = Team::find($teamId);
        // Find role student
        $student = Role::where('name', 'student')->first();

        // Get ACL permission for student
        $readAcl = Permission::where('name', 'read-acl')->first();
        $updateAcl = Permission::where('name', 'update-acl')->first();

        // Attach permission for student to team
        $user->attachPermissions([$readAcl,$updateAcl], $team);
        $user->attachRole($student,$team);

        // Show flash msg
        Session::flash('success', 'User was successfully added to group.');

        // Return to manage
        return back();
    }
}
