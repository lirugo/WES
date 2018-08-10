<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['user_id','team_id','title','start_date','end_date'];
}
