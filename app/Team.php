<?php

namespace App;

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
     * Get All Students of Team
     * @return mixed
     */
    public function getStudents(){
        $users = User::with('rolesTeams')->whereRoleIs('student')->get();

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

        return $users;
    }

    /**
     * Check User is Member of Team
     * @param User $user
     * @return bool
     */
    public function isMember(User $user){
//        $members = User::with('rolesTeams')->all();
//        foreach ($members as $member)
//            if($member == $user)
//                return true;
//
//        return false;
    }

    /**
     * Get Schedule of group
     * @return array
     */
    public function getSchedule(){
         return $this->schedules;
    }
}
