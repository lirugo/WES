<?php

namespace App;

use App\Http\Resources\StudentApiResource;
use App\Models\Team\CommonFile;
use App\Models\Team\Pretest;
use App\Models\Team\TeamHeadman;
use App\Models\Team\TeamLessonTime;
use Auth;
use Laratrust\Models\LaratrustTeam;

class Team extends LaratrustTeam
{
    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    /**
     * Relationship to schedule list
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(){
        return $this->hasMany(Schedule::class, 'team_id', 'id');
    }

    public function getTeacherSchedules(){
        $schedules = $this->schedules;
        foreach ($schedules as $key => $schedule)
            if($schedule->teacher_id != Auth::user()->id)
                $schedules->forget($key);

        return $schedules;
    }

    /**
     * Relationship to discipline list
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disciplines(){
        return $this->hasMany(TeamDiscipline::class)->with('getTeacher', 'getDiscipline', 'discipline');
    }

    /**
     * Relationship to discipline list
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disciplinesAsc(){
        $disciplines = $this->hasMany(TeamDiscipline::class)->with('getTeacher', 'getDiscipline', 'discipline')->get();

        //By ABC sort
        $disciplines = $disciplines->sortBy('discipline.name');

        return $disciplines;
    }

    public function disciplinesForTeam($teamId){
        return $this->hasMany(TeamDiscipline::class)->where('team_id', $teamId)->where('disabled', false)->with('getTeacher', 'getDiscipline')->get();
    }

    public function getDisciplines($userId){
        return $this->disciplines()->where('teacher_id', '=', $userId)->get();
    }

    /**
     * Get owner team
     * @return User
     */
    public function getOwner(){
        $owner = null;
        $users = User::with('rolesTeams')->whereRoleIs('owner')->get();
        foreach($users as $user){
            foreach($user->rolesTeams as $t)
                if($t->name == $this->name)
                    $owner = $user;
        }
        return $owner;
    }

    /**
     * Get All Members of Group
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMembers(){
        $users = User::with('rolesTeams')->get();

        foreach ($users as $key => $user){
            $count = 0;
            foreach ($user->rolesTeams as $t) {
                if ($this->name == $t->name)
                    $count++;
            }
            if($count == 0)
                $users->forget($key);
        }

        return $users;
    }
    /**
     * Get All Members of Group
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function pretests($disciplineId){
        return $this->hasMany(Pretest::class, 'team_id', 'id')->where('discipline_id', $disciplineId);
    }

    /**
     * Get All Students of Team
     * @return mixed
     */
    public function getStudents(){
        $users = User::with(['rolesTeams', 'name'])->whereRoleIs('student')->get();

        //By ABC sort
        $users = $users->sortBy('name.second_name');

        foreach ($users as $key => $user){
            $count = 0;
            foreach ($user->rolesTeams as $t) {
                if ($this->name == $t->name)
                    $count++;
            }
            if($count == 0)
                $users->forget($key);

        }

        return $users;
    }

    public function getApiStudents(){
        $users = User::with(['rolesTeams', 'name'])->whereRoleIs('student')->get();

        //By ABC sort
        $users = $users->sortBy('name.second_name');

        $students = [];

        foreach ($users as $key => $user){
            $count = 0;
            foreach ($user->rolesTeams as $t) {
                if ($this->name == $t->name)
                    $count++;
            }
            if($count == 0)
                $users->forget($key);
            else
                array_push($students, new StudentApiResource($user));
        }

        return $students;
    }

    public function getApiDescStudents(){
        $users = User::with(['rolesTeams', 'name'])->whereRoleIs('student')->get();

        //By ABC sort
        $users = $users->sortBy('name.second_name');

        $students = [];

        foreach ($users as $key => $user){
            $count = 0;
            foreach ($user->rolesTeams as $t) {
                if ($this->name == $t->name)
                    $count++;
            }
            if($count == 0)
                $users->forget($key);
            else
                array_push($students, $user->getShortName().' '.$user->jobs[0]->name.' '.$user->jobs[0]->position.' '.$user->jobs[0]->experience.' years');
        }
        return $students;
    }

    /**
     * Get All Teachers of Team
     * @return mixed
     */
    public function getTeachers(){
        $users = User::with('rolesTeams')->whereRoleIs('teacher')->get();

        foreach ($users as $key => $user){
            $count = 0;
            foreach ($user->rolesTeams as $t) {
                if ($this->name == $t->name)
                    $count++;
            }
            if($count == 0)
                $users->forget($key);

        }

        //By ABC sort
        $users = $users->sortBy('name.second_name');

        return $users;
    }

    /**
     * Get Schedule of group
     * @return array
     */
    public function getSchedule(){
        return $this->schedules;
    }

    /**
     * Get Current Discipline
     * @param $disciplineId
     * @return mixed
     */
    public function getDiscipline($disciplineId){
        return $this->disciplines->where('discipline_id', $disciplineId)->first();
    }

    /**
     * Check If User is Member of Group
     * @param $user
     * @return bool
     */
    public function isMember($user){
        foreach($this->getMembers() as $member)
            if($user->id == $member->id)
                // Allow
                return true;
        // Deny
        return false;
    }

    public function isHeadman($id){
        return (boolean) count($this->hasOne(TeamHeadman::class, 'team_id', 'id')->where('student_id', $id)->get());
    }

    public function lessonsTime(){
        return $this->hasMany(TeamLessonTime::class, 'team_id', 'id');
    }

    public function commonFiles(){
        return $this->hasMany(CommonFile::class);
    }
}
