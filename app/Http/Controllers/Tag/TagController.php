<?php

namespace App\Http\Controllers\Tag;

use App\Http\Requests\StoreTag;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::all();
        return view('tag.index')
            ->withTags($tags);
    }

    public function create(){
        return view('tag.create');
    }

    public function store(StoreTag $request){
        // Persist
        Tag::create($request->only(['name', 'display_name']));
        // Flash
        Session::flash('success', 'Tag was successfully created');
        // Redirect
        return redirect(url('/library'));
    }

    public function delete($id){
        // Delete
        Tag::find($id)->delete();
        // Flash
        Session::flash('success', 'Tag was successfully deleted');
        // Redirect
        return redirect(url('/tag'));

    }

    public function json(){
        $tags = Tag::all();
        $data = [];
        foreach ($tags as $tag){
            $data[$tag->display_name] = null;
        }

        return $data;
    }
}
