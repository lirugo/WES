<?php

namespace App\Models\Team;

use App\Discipline;
use App\Team;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GroupWork extends Model
{
    protected $table = 'teams_group_works';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function files(){
        return $this->hasMany(GroupWorkFile::class, 'group_work_id', 'id');
    }

    public function isFinished(){
        $end = Carbon::now()->diffInMinutes($this->end_date, false) > 0;

        if($this->finished)
            return $this->finished;

        if(!$end)
            return !$end;

        return false;
    }

    public function getSubTeams(){
        return GroupWorkSubTeam::where('group_work_id', $this->id)->get();
    }

    public function getSubTeam($studentId){
        $subTeams = $this->getSubTeams();
        $team = null;
        foreach ($subTeams as $subTeam){
            if($subTeam->isMember($studentId))
                return $subTeam;
        }

        return null;
    }

    public function getMark($studentId){
        $subTeams = $this->getSubTeams();
        $team = null;
        foreach ($subTeams as $subTeam){
            if($subTeam->isMember($studentId))
                $team = $subTeam;
        }

        if($team != null)
            return $team->getMark($studentId);

        return null;
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function discipline(){
        return $this->belongsTo(Discipline::class);
    }
}
