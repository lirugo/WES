<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class GroupWorkSubTeamDeadline extends Model
{
    protected $table = 'teams_group_works_sub_teams_deadlines';
    protected $guarded = ['id'];
    public $timestamps = true;
}
