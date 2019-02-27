<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['team_id','teacher_id','discipline_id','title','start_date','end_date'];

    public function tools(){
        return $this->hasMany(ScheduleTool::class, 'schedule_id');
    }

    public function getTools(){
        foreach ($this->tools as $tool){
            $tools[] = $tool->title;
        }


        return isset($tools) ? $tools : [];
    }
}
