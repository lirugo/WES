<?php

namespace App\Models\Team;

use App\User;
use Illuminate\Database\Eloquent\Model;

class GroupWorkSubTeamMembers extends Model
{
    protected $table = 'teams_group_works_sub_teams_members';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id')->with('name');
    }
}
