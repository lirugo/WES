<?php

namespace App;

use App\Models\Team\PretestUserAnswer;
use Illuminate\Database\Eloquent\Model;

class UserStudent extends Model
{
    protected $table = 'users_students';

    protected $guarded = ['id'];
}
