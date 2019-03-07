<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Auth;

class NotificationController extends Controller
{
    public function index(){
        return view('notification.index')
            ->withNotifications(Auth::user()->notifications);
    }
}
