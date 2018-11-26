<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Pretest extends Model
{
    protected $guarded = ['id'];
    public $timestamps = true;

    public function files(){
        return $this->hasMany(PretestFile::class, 'pretest_id', 'id');
    }

    public function questions(){
        return $this->hasMany(PretestQuestion::class, 'pretest_id', 'id');
    }
}
