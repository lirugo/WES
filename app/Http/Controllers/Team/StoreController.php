<?php

namespace App\Http\Controllers\Team;

use App\Permission;
use App\Role;
use App\Team;
use App\User;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function student(Request $request, $teamName){
        // Validate access

        // Find user
        $user = User::find($request->student);

        // Find team
        $team = Team::where('name', $teamName)->first();

        // Find role student
        $student = Role::where('name', 'student')->first();

        // Get ACL permission for student
        $readAcl = Permission::where('name', 'read-acl')->first();
        $updateAcl = Permission::where('name', 'update-acl')->first();

        // Attach permission for student to team
        $user->attachPermissions([$readAcl,$updateAcl], $team);
        $user->attachRole($student,$team);

        // Show flash msg
        Session::flash('success', 'Student was successfully added to group.');

        // Return to manage
        return back();
    }

    public function teacher(Request $request, $teamName){
        // Validate access

        // Find user
        $user = User::find($request->teacher);

        // Find team
        $team = Team::where('name', $teamName)->first();

        // Find role student
        $teacher = Role::where('name', 'teacher')->first();

        // Get ACL permission for teacher
        $readAcl = Permission::where('name', 'read-acl')->first();
        $updateAcl = Permission::where('name', 'update-acl')->first();

        // Attach permission for student to team
        $user->attachPermissions([$readAcl,$updateAcl], $team);
        $user->attachRole($teacher,$team);

        // Show flash msg
        Session::flash('success', 'Teacher was successfully added to group.');

        // Return to manage
        return back();
    }
}
