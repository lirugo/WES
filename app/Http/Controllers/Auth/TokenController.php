<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    public function index(Request $request){
//        Check if user have user id in session
        if(!$request->session()->has('key')){
            //Redirect to home page
            return redirect()->to('/');
        }
        //Show token page
        return view('auth.token');
    }

    public function token(Request $request){
        $this->validate($request, [
            'key' => 'required'
        ]);

        $key = $request->session()->get('key');
        if($key == $request->key) {
            Auth::loginUsingId($request->session()->get('user_id'), true);
            $request->session()->forget('key');
            $request->session()->forget('user_id');
            return redirect(url('/'));
        }
        else
        {
            $request->session()->forget('key');
            $request->session()->forget('user_id');
            return redirect(url('/'));
        }
    }
}
