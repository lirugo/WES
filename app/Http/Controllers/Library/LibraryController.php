<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests\StoreLibrary;
use App\Models\Library\Library;
use App\Models\Library\LibraryAuthor;
use App\Models\Library\LibraryTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Session;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libraries = Library::all();
        return view('library.index')
            ->withLibraries($libraries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('library.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLibrary $request
     * @return void
     */
    public function store(StoreLibrary $request)
    {
        // Persist
        $library = new Library();
        $library->title = $request->title;
        $library->description = $request->description;
        $library->pages = $request->pages;
        $library->year = $request->year;
        $library->image = $request->avatar;
        $filePath = Storage::disk('library')->put('/', $request->file);
        $library->file =  basename($filePath);
        $library->save();

        foreach (json_decode($request->tags) as $tag){
            $tag = Tag::where('display_name', $tag)->first();
            LibraryTag::create([
                'tag_id' => $tag->id,
                'library_id' => $library->id
            ]);
        }
        // Flash msg
        Session::flash('success', 'The library was successful replenished');

        // Return
        return redirect(url('/library/'.$library->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $library = Library::find($id);

        return view('library.show')
            ->withLibrary($library);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function image(Request $request){
        if($request->hasFile('avatar')){
            $filePath = Storage::disk('library')->put('/image', $request->avatar);
            basename($filePath);
            return json_encode(['status' => 'OK', 'avatar' => basename($filePath)]);
        }
    }

    public function getImage($name){
        $path = storage_path('\app\library\image\/'.$name);
        return response()->file($path);
    }

    public function authorUpdate(Request $request, $id){
        LibraryAuthor::create([
            'library_id' => $id,
            'second_name' => $request->second_name,
            'name' => $request->name,
            'middle_name' => $request->middle_name,
        ]);

        // Flash msg
        Session::flash('success', 'The author was successful added');

        // Return
        return redirect(url('/library/'.$id));
    }

    public function getFile($name){
        $path = storage_path('\app\library\/'.$name);
        return response()->file($path);}
}
