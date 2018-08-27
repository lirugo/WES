<?php

namespace App\Http\Controllers\Tag;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\Object_;

class TagController extends Controller
{
    public function json(){
        $tags = Tag::all();
        $data = [];
        foreach ($tags as $tag){
            $data[$tag->display_name] = null;
        }

        return $data;
    }
}
