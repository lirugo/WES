<?php

namespace App\Models\Team;

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
}
