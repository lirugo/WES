<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class PretestQuestion extends Model
{
    //All answers
    public function answers(){
        return $this->hasMany(PretestAnswer::class, 'pretest_question_id', 'id');
    }

    //Correct answer
    public function answer(){
        return $this->hasOne(PretestAnswer::class, 'pretest_question_id', 'id')->where('is_answer', '=', true)->first();
    }
}
