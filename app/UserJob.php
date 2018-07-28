<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    protected $table = 'users_jobs';

    protected $guarded = ['id'];
}
