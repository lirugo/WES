<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class GroupWork extends Model
{
    protected $table = 'teams_group_works';
    protected $guarded = ['id'];
    public $timestamps = false;
}
