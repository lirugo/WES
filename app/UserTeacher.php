<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTeacher extends Model
{
    protected $table = 'users_teachers';

    protected $guarded = ['id'];
}
