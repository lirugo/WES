<?php

namespace App\Models\Team;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TeamActivityReply extends Model
{
    protected $guarded = ['id'];
    public $timestamps = true;

    public function teacher(){
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    public function student(){
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    public function files(){
        return $this->hasMany(TeamActivityFile::class, 'reply_id', 'id');
    }
}
