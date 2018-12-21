<?php

namespace App\Models\Team;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GroupWorkSubTeam extends Model
{
    protected $table = 'teams_group_works_sub_teams';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function members(){
        return $this->hasMany(GroupWorkSubTeamMembers::class, 'subteam_id', 'id')->with('user');
    }

    //Get sub team deadline common or specific
    public  function getDeadline(){
        if($this->hasOne(GroupWorkSubTeamDeadline::class, 'subteam_id', 'id')->first())
             $deadline = $this->hasOne(GroupWorkSubTeamDeadline::class, 'subteam_id', 'id')->first();
        else
            $deadline = $this->hasOne(GroupWork::class, 'id', 'group_work_id')->first();

        return json_encode(['startDate' => Carbon::parse($deadline->start_date)->format('Y-m-d'), 'endDate' => Carbon::parse($deadline->end_date)->format('Y-m-d')]);
    }
}
