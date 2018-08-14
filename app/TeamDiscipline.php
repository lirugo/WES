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

    public function getHomeWork(){
        return TeamsHomeWork::where([
            ['team_id', $this->team_id],
            ['discipline_id', $this->discipline_id]
        ])->orderBy('id', 'DESC')->get();
    }
}
