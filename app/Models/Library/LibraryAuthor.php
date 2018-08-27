<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Model;

class LibraryAuthor extends Model
{
    protected $guarded = ['id'];

    public function getShortName(){
        return $this->second_name.' '.substr($this->name,0,1).'. '.substr($this->middle_name,0,1).'.';
    }
}
