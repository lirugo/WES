<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Http\Requests\StoreTeam;
use App\Http\Requests\UpdateTeam;
use App\Models\Team\TeamHeadman;
use App\Models\Team\TeamLessonTime;
use App\Models\Team\TeamTeacherLessonHour;
use App\Permission;
use App\Role;
use App\Team;
use App\TeamDiscipline;
use App\TeamTemplate;
use App\TeamTemplateDiscipline;
use App\TeamTemplateLessonTime;
use App\User;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;
use Auth;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function index(){
        $teams = Auth::user()->teams();
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
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        //Set lesson time from template
        foreach ($template->lessonsTime as $time){
            TeamLessonTime::create([
                'team_id' => $team->id,
                'position' => $time->position,
                'start_time' => $time->start_time,
                'end_time' => $time->end_time,
            ]);
        }

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
                'discipline_id' => $discipline->discipline_id,
                'hours' => $discipline->hours,
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
        return redirect(url('/team/'.$team->name));
    }

    public function show($name){
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
        $teamTemplateDisciplines = TeamTemplateDiscipline::all();

        // Render View
        return view('team.show')
            ->withTeam($team)
            ->withStudents($students)
            ->withTeachers($teachers)
            ->withDisciplines($disciplines)
            ->withTeamTemplateDisciplines($teamTemplateDisciplines);
    }

    public function studentDelete($teamId, $studentId){
        // Validate access

        // Find user
        $user = User::find($studentId);

        // Find team
        $team = Team::find($teamId);

        // Find role student
        $student = Role::where('name', 'student')->first();

        // Get ACL permission for student
        $readAcl = Permission::where('name', 'read-acl')->first();
        $updateAcl = Permission::where('name', 'update-acl')->first();

        // Detach permission for student to team
        $user->detachPermissions([$readAcl->id, $updateAcl->id]);
        $user->detachRole($student, $team);

        // Show flash msg
        Session::flash('success', 'Student was successfully deleted from group.');

        // Return to manage
        return back();
    }

    public function update(UpdateTeam $request, $team){
        // Find team
        $team = Team::where('name', $team)->first();

        // Update
        $team->update([
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        // Show flash msg
        Session::flash('success', 'Team was successfully updated.');

        // Return to manage
        return back();
    }

    public function setHeadman(Request $request, $team){
        $team = Team::where('name', $team)->first();
        TeamHeadman::where('team_id', $team->id)->delete();
        TeamHeadman::create([
            'team_id' => $team->id,
            'student_id' => $request->student_id
        ]);
        Session::flash('success', 'Headman was been successfully updated');
        return back();
    }

    public function disciplineDisable($team, $teamDisciplineId){
        $teamDiscipline = TeamDiscipline::find($teamDisciplineId);
        $disabled = $teamDiscipline->disabled;
        $teamDiscipline->disabled = $disabled ? false : true;
        $teamDiscipline->save();

        Session::flash('success', 'Discipline updated');
        return back();
    }
}
