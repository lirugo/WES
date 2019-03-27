<?php

namespace App\Http\Controllers\Team;

use App\Permission;
use App\Role;
use App\Team;
use App\TeamDiscipline;
use App\TeamTemplateDiscipline;
use App\User;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher');
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
        $user->attachRole($student, $team);

        // Show flash msg
        Session::flash('success', 'Student was successfully added to group.');

        // Return to manage
        return back();
    }

    public function discipline(Request $request, $team){
        //Get data
        $team = Team::where('name', $team)->first();
        $teamTemplateDisciplines = TeamTemplateDiscipline::find($request->teamTemplateDisciplines);

        //Persist
        TeamDiscipline::create([
            'team_id' => $team->id,
            'teacher_id' => $teamTemplateDisciplines->teacher_id,
            'discipline_id' => $teamTemplateDisciplines->discipline_id,
            'hours' => $teamTemplateDisciplines->hours,
        ]);

        foreach ($team->getTeachers() as $teacher){
            $count = 0;
            if($teacher->id == $teamTemplateDisciplines->teacher_id)
                $count++;
        }

        if($count == 0){
            $teacher = User::find($teamTemplateDisciplines->teacher_id);

            // Find role teacher
            $roleTeacher = Role::where('name', 'teacher')->first();

            // Attach role for teacher in team
            $teacher->attachRole($roleTeacher, $team);
        }


        //Redirect
        Session::flash('success', 'Discipline was be added');
        return back();
    }
}
