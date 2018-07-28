<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserName extends Model
{
    protected $table = 'users_names';

    protected $guarded = ['id'];
}
