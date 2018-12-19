<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class GroupWorkFile extends Model
{
    protected $table = 'team_group_work_files';
    protected $guarded = ['id'];
    public $timestamps = false;
}
