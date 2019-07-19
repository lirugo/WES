<?php

namespace App\Http\Controllers\User;

use App\User;
use App\UserSettingNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class SettingsController extends Controller
{
    public function index(){
        return view('user.settings.index');
    }

    public function update(Request $request){
        //Notifications
        //New or update
        $userSettNotif = UserSettingNotification::where('user_id', auth()->id())->first();
        if($userSettNotif == null){
            $userSettNotif = new UserSettingNotification();
            $userSettNotif->user_id = auth()->id();
        }
        //SMS
        $userSettNotif->sms_new_mark = $request->sms_new_mark == 'on' ? true : false;
        $userSettNotif->sms_new_group_work = $request->sms_new_group_work == 'on' ? true : false;
        $userSettNotif->sms_new_activity_message = $request->sms_new_activity_message == 'on' ? true : false;
        $userSettNotif->sms_new_activity = $request->sms_new_activity == 'on' ? true : false;
        $userSettNotif->sms_new_test = $request->sms_new_test == 'on' ? true : false;
        $userSettNotif->sms_update_schedule = $request->sms_update_schedule == 'on' ? true : false;
        $userSettNotif->sms_update_activity = $request->sms_update_activity == 'on' ? true : false;
        //EMAIL
        $userSettNotif->email_new_mark = $request->email_new_mark == 'on' ? true : false;
        $userSettNotif->email_new_group_work = $request->email_new_group_work == 'on' ? true : false;
        $userSettNotif->email_new_activity_message = $request->email_new_activity_message == 'on' ? true : false;
        $userSettNotif->email_new_activity = $request->email_new_activity == 'on' ? true : false;
        $userSettNotif->email_new_test = $request->email_new_test == 'on' ? true : false;
        $userSettNotif->email_update_schedule = $request->email_update_schedule == 'on' ? true : false;
        $userSettNotif->email_update_activity = $request->email_update_activity == 'on' ? true : false;

        $userSettNotif->save();

        //Language
        $user = User::find(auth()->id());
        $user->language = $request->language;
        $user->save();

        Session::flash('success', 'User setting was be updated');
        return back();
    }
}
