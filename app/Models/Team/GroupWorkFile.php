<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class GroupWorkFile extends Model
{
    protected $table = 'teams_group_works_files';
    protected $guarded = ['id'];
    public $timestamps = true;
}