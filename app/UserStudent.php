<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStudent extends Model
{
    protected $table = 'users_students';

    protected $guarded = ['id'];
}
