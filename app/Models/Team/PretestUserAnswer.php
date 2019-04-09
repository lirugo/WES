<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class PretestUserAnswer extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function isAnswer(){
        return (boolean) $this->hasOne(PretestAnswer::class, 'id', 'pretest_answer_id')->first() ? $this->hasOne(PretestAnswer::class, 'id', 'pretest_answer_id')->first()->is_answer : false;
    }
}
