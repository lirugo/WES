<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamsHomeWork extends Model
{
    protected $guarded = ['id'];

    public function getFiles(){
        return $this->hasMany(TeamsHomeWorkFile::class, 'homework_id', 'id');
    }
}
