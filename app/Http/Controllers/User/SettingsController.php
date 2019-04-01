<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class SettingsController extends Controller
{
    public function index(){
        return view('user.settings.index');
    }

    public function update(Request $request){
        dd($request->all());

        Session::flash('success', 'User setting was be updated');
        return back();
    }
}
