<?php

namespace App\Http\Controllers;

use App\Mail\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller
{
    public function send(Request $request){
        Mail::to('maksim.dolgov@iib.com.ua')->send(new Feedback(Auth::user(), $request->title, $request->body));
        Session::flash('success', 'Feedback was successfully sent');
        return back();
    }
}
