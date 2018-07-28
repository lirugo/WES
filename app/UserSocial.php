<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    protected $table = 'users_socials';

    protected $guarded = ['id'];
}
