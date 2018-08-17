<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamTemplateDiscipline extends Model
{
    protected $table = 'teams_template_disciplines';

    protected $guarded = ['id'];

    public function getDiscipline(){
        return $this->hasOne(Discipline::class, 'id', 'discipline_id');
    }

    public function getTeacher(){
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }
}
