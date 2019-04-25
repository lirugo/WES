<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Notifications\Notification;
use Session;

class NotificationController extends Controller
{
    public function index(){
        return view('notification.index');
    }

    public function markAll(){
        foreach (Auth()->user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        Session::flash('success', 'Notification was be updated');
        return back();
    }

    public function markasread($id){
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
    }
}
