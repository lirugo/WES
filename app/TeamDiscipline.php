<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamDiscipline extends Model
{
    protected $table = 'teams_disciplines';

    protected $guarded = ['id'];

    public function getDiscipline(){
        return $this->hasOne(Discipline::class, 'id', 'discipline_id');
    }

    public function getTeacher(){
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    public function team(){
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function getTasks(){
        return $this->hasMany(TeamTask::class, 'discipline_id', 'id')->where('team_id', '=', $this->team_id);
    }

    public function getHomeWork(){
        return TeamsHomeWork::where([
            ['team_id', $this->team_id],
            ['discipline_id', $this->discipline_id]
        ])->orderBy('id', 'DESC')->get();
    }

    public function getCountPoints(){
        $points = 0;
        foreach ($this->getTasks as $task)
            $points += $task->max_mark;
        return $points;
    }
}
