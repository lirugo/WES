<?php

namespace App\Models\Team;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Auth;

class GroupWorkSubTeam extends Model
{
    protected $table = 'teams_group_works_sub_teams';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function members(){
        return $this->hasMany(GroupWorkSubTeamMembers::class, 'subteam_id', 'id')->with('user');
    }

    //Get sub team deadline common or specific
    public function getDeadline(){
        if($this->hasOne(GroupWorkSubTeamDeadline::class, 'subteam_id', 'id')->first())
             $deadline = $this->hasOne(GroupWorkSubTeamDeadline::class, 'subteam_id', 'id')->first();
        else
            $deadline = $this->hasOne(GroupWork::class, 'id', 'group_work_id')->first();

        return json_encode(['startDate' => Carbon::parse($deadline->start_date)->format('Y-m-d'), 'endDate' => Carbon::parse($deadline->end_date)->format('Y-m-d')]);
    }

    //Check sub team is finished
    public function isFinished(){
        $groupWork = $this->hasOne(GroupWork::class, 'id', 'group_work_id')->first();

        if($groupWork->isFinished())
            return true;

        if($this->finished == 1)
            return true;

        $start = Carbon::now()->diffInMinutes(json_decode($this->getDeadline())->startDate, false) < 0;
        $end = Carbon::now()->diffInMinutes(json_decode($this->getDeadline())->endDate, false) > 0;
        $open = ($start + $end) == 2;

        if(!$open)
            return !$open;

        return false;
    }

    public function hasMark($studentId){
        if(Auth::user()->hasRole('student')) {
            $mark = $this->hasMany(GroupWorkSubTeamMembers::class, 'subteam_id', 'id')->where('user_id', $studentId)->first()->mark;
            return $mark != 0;
        }else
            return false;
    }
}
