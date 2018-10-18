<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamTask extends Model
{
    protected $guarded = ['id'];

    public function homework(){
        return $this->hasOne(TeamsHomeWork::class, 'id', 'homework_id');
    }

    public function getMark($id){
        return $this->hasMany(TeamMark::class, 'task_id', 'id')->where('user_id', '=', $id)->first();
    }
}
