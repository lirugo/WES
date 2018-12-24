<?php

namespace App\Models\Team;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GroupWork extends Model
{
    protected $table = 'teams_group_works';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function files(){
        return $this->hasMany(GroupWorkFile::class, 'group_work_id', 'id');
    }

    public function isFinished(){
        $end = Carbon::now()->diffInMinutes($this->end_date, false) > 0;

        if($this->finished)
            return $this->finished;

        if(!$end)
            return !$end;

        return false;
    }
}
