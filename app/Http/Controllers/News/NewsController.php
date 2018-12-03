<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNews;
use App\News;
use Auth;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $news = News::all();
        return view('news.index')->withNews($news);
    }

    public function create(){
        if(!Auth::user()->hasRole(['administrator', 'top-manager']))
            abort(403);

        return view('news.create');
    }

    public function store(StoreNews $request){
        if(!Auth::user()->hasRole(['administrator', 'top-manager']))
            abort(403);
        // Create news
        News::create([
            'title' => $request->title,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        // Flash msg
        Session::flash('success', 'News was successfully created.');
        // Redirect back
        return redirect(url('news'));
    }
}
