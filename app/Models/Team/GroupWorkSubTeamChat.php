<?php

namespace App\Models\Team;

use App\User;
use Illuminate\Database\Eloquent\Model;

class GroupWorkSubTeamChat extends Model
{
    protected $table = 'teams_group_works_sub_teams_chats';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function author(){
        return $this->hasOne(User::class, 'id', 'user_id')->with('name');
    }

    public function files(){
        return $this->hasMany(GroupWorkFile::class, 'chat_id', 'id');
    }
}
