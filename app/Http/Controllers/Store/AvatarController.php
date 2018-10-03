<?php

namespace App\Http\Controllers\Store;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvatarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request){
        if($request->hasFile('avatar')){
            $file = $request->avatar;

            $destinationPath = public_path() . '/uploads/avatars/';
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $filename);
            return json_encode(['status' => 'OK', 'avatar' => $filename]);
        }
    }

    public function update(Request $request, $id){
        if($request->hasFile('avatar')){
            $file = $request->avatar;

            $destinationPath = public_path() . '/uploads/avatars/';
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $filename);

            $student = User::find($id);
            $student->avatar = $filename;
            $student->save();

            return json_encode(['status' => 'OK', 'avatar' => $filename]);
        }
    }
}
