<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    protected $guarded = ['id'];

    public function author(){
        return $this->belongsTo(User::class);
    }
    public function target(){
        return $this->belongsTo(User::class);
    }
}
