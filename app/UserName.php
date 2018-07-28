<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserName extends Model
{
    protected $table = 'users_names';

    protected $fillable = [
        'user_id', 'language', 'second_name', 'name', 'middle_name'
    ];
}
