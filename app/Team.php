<?php

namespace App;

use Laratrust\Models\LaratrustTeam;

class Team extends LaratrustTeam
{
    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    /**
     * Get owner team.
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

    public function getMembers(){
        $users = User::with('rolesTeams')->whereRoleIs('student')->get();

        foreach ($users as $key => $user)
            if(count($user->rolesTeams) == 0 || $user->hasRole('manager'))
                $users->forget($key);

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
}
