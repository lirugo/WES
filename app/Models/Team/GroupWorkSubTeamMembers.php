<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class GroupWorkSubTeamMembers extends Model
{
    protected $table = 'teams_group_works_sub_teams_members';
    protected $guarded = ['id'];
    public $timestamps = true;
}
