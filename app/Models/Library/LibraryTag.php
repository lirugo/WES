<?php

namespace App\Models\Library;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class LibraryTag extends Model
{
    protected $table = 'library_tags';

    protected $guarded = ['id'];

    public function get(){
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }
}
