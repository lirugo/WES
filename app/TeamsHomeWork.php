<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TeamsHomeWork extends Model
{
    protected $guarded = ['id'];

    // Get All Solutions For Current HomeWork
    public function solutions(){
        return $this->hasMany(TeamsHomeWorkSolution::class, 'homework_id', 'id');
    }

    public function getFiles(){
        return $this->hasMany(TeamsHomeWorkFile::class, 'homework_id', 'id')->where('status','task')->get();
    }

    // Get Solutions For Current User
    public function getSolution(){
        return $this->solutions()->where('student_id', Auth::user()->id)->first();
    }
}
