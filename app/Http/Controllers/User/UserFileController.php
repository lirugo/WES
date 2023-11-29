<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

class UserFileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
           $userFile = new UserFile();
           $userFile->uploader_id = Auth()->user()->id;
           $userFile->user_id = $request->user_id;
           $userFile->name_ua = $request->name_ua;
           $userFile->name_en = $request->name_en;
           $userFile->size = $request->file->getSize();
           $userFile->extension = $request->file->getClientOriginalExtension();

           $fileHash = str_replace('.' . $request->file->extension(), '', $request->file->hashName());
           $fileName = $fileHash . '.' . $request->file->getClientOriginalExtension();
           Storage::putFileAs('user/file', $request->file, $fileName);
           $userFile->file_name = $fileName;
           $userFile->save();

           Session::flash('success', "File was be saved");
           return redirect()->back();
       }

    /**
     * Display the specified resource.
     *
     * @param  $fileId
     * @return \Illuminate\Http\Response
     */
    public function get($fileId)
    {
       $file = UserFile::where('id', $fileId)->first();
       $path = storage_path('/app/user/file/'.$file->file_name);
       $info = pathinfo($path);

       return response()->download($path, $file->name_en.'.'.$info['extension']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $fileId
     * @return \Illuminate\Http\Response
     */
    public function destroy($fileId)
    {
        $file = UserFile::find($fileId);
        $file->delete();
        Session::flash('success', 'Deleted');
        return back();
    }
}
