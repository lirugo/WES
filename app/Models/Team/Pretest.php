<?php

namespace App\Models\Team;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pretest extends Model
{
    protected $guarded = ['id'];
    public $timestamps = true;

    public function files(){
        return $this->hasMany(PretestFile::class, 'pretest_id', 'id');
    }

    public function questions(){
        return $this->hasMany(PretestQuestion::class, 'pretest_id', 'id');
    }

    public function isAnswer($questionId, $answerId){
        $answers = PretestQuestion::find($questionId)->rightAnswers();

        foreach ($answers as $answer)
            if ($answer->id == $answerId) return true;

        return false;
    }

    //Is open
    public function isOpen(){
        $start = Carbon::now()->diffInMinutes($this->start_date, false) < 0;
        $end = Carbon::now()->diffInMinutes($this->end_date, false) > 0;
        $locked = ($start + $end) == 2;
        return $locked;
    }

    //Is available
    public function isAvailable($userId){
        $access = !(boolean) count($this->hasMany(PretestUserAccess::class, 'pretest_id', 'id')->where('user_id', '=', $userId)->get());
        $start = Carbon::now()->diffInMinutes($this->start_date, false) < 0;
        $end = Carbon::now()->diffInMinutes($this->end_date, false) > 0;
        $available = ($access + $start + $end) == 3;
        return  $available;
    }

    //Is editable pretest
    public function isEditable(){
        $start = Carbon::now()->diffInMinutes($this->start_date, false) - 720 > 0;
        return $start;
    }

    //Has access
    public function hasAccess($studentId){
        $access = $this->hasOne(PretestUserAccess::class, 'pretest_id', 'id')->where('user_id', '=', $studentId)->get();
        return (boolean) count($access) == 0;
    }
}
