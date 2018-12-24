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
        $start = Carbon::now()->diffInMinutes($this->start_date, false) < 0;
        $end = Carbon::now()->diffInMinutes($this->end_date, false) > 0;
        $open = ($start + $end) == 2;

        if($this->finished)
            return $this->finished;

        if(!$open)
            return !$open;

        return false;
    }
}
