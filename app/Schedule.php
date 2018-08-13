<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['team_id','teacher_id','discipline_id','title','start_date','end_date'];
}
