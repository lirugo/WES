<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class TeamsHomeWorkSolution extends Model
{
    protected $table = 'teams_home_works_solutions';

    protected $guarded = ['id'];

    public function files(){
        return $this->hasMany(TeamsHomeWorkFile::class, 'homework_id', 'homework_id');
    }

    // Get Files For Current Solution&User
    public function getFiles(){
        return $this->files()->where([
            ['student_id', Auth::user()->id],
            ['status', 'solution']
        ])->get();
    }

    public function owner(){
        return $this->hasOne(User::class, 'id', 'student_id');
    }
}
