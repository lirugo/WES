<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    protected $guarded = ['id'];
    public $timestamps = true;

    public function uploader(){
        return $this->hasOne(User::class, 'id', 'uploader_id');
    }
}
