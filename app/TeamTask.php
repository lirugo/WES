<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamTask extends Model
{
    protected $guarded = ['id'];

    public function homework(){
        return $this->hasOne(TeamsHomeWork::class, 'id', 'homework_id');
    }
}
