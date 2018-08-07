<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDiscipline extends Model
{
    protected $table = 'users_disciplines';

    protected $guarded = ['id'];

    public function get(){
        return $this->hasOne(Discipline::class, 'id', 'discipline_id');
    }
}
