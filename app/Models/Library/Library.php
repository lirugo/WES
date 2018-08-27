<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    public function tags(){
        return $this->hasMany(LibraryTag::class);
    }
    public function authors(){
        return $this->hasMany(LibraryAuthor::class);
    }
}
