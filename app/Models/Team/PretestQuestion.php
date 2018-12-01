<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class PretestQuestion extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    //All answers
    public function answers(){
        return $this->hasMany(PretestAnswer::class, 'pretest_question_id', 'id');
    }

    public function userAnswers(){
        return $this->hasMany(PretestUserAnswer::class, 'pretest_question_id', 'id');
    }

    //Correct answer
    public function rightAnswers(){
        return $this->hasMany(PretestAnswer::class, 'pretest_question_id', 'id')->where('is_answer', '=', true)->get();
    }
}
