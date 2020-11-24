<?php

namespace App\Models\Team;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TeamVideoLesson extends Model
{
    public function getOwner(){
        return $this->hasOne(User::class, 'id', 'owner_id');
    }
}
