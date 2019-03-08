<?php

namespace App\Models\Team;

use App\Discipline;
use App\Team;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TeamActivity extends Model
{
    protected $guarded = ['id'];
    public $timestamps = true;

    public function getType(){
        foreach (config('activity') as $key => $activity){
            if($key == $this->type)
                return $activity;
        }
        return null;
    }

    public function files(){
        return $this->hasMany(TeamActivityFile::class, 'activity_id', 'id');
    }

    //Is open
    public function isOpen(){
        $start = Carbon::now()->diffInMinutes($this->start_date, false) < 0;
        $end = Carbon::now()->diffInMinutes($this->end_date, false) > 0;
        $locked = ($start + $end) == 2;
        return $locked;
    }

    public function getMark($studentId){
        return $this->hasOne(TeamActivityMark::class, 'activity_id', 'id')->where([
            ['student_id', $studentId],
            ['type', 'activity'],
        ])->first();
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function discipline(){
        return $this->belongsTo(Discipline::class);
    }
}
