<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class GroupWorkSubTeam extends Model
{
    protected $table = 'teams_group_works_sub_teams';
    protected $guarded = ['id'];
    public $timestamps = true;
}
