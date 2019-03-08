<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Notifications\User\NotifUpdatePass;
use App\Notifications\User\NotifUpdateProfile;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class ProfileController extends Controller
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
        $user = Auth::user();
        return view('user.profile.index')
            ->withUser($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->updateProfile($request);

        $managers = User::whereHas(
            'roles', function($q){
            $q->where('name', 'manager');
        }
        )->get();

        // Send notification
        foreach ($managers as $manager)
            $manager->notify(new NotifUpdateProfile($user));

        // Show flash msg
        Session::flash('success', 'Profile was successfully updated.');

        // Redirect to manage page
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setAvatar(Request $request)
    {
        $user = Auth::user();
        $user->avatar = $request->avatar;
        $user->save();
        return $request->avatar;
    }

    public function resetPassword(Request $request){
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->withErrors("Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current_password'), $request->get('password')) == 0){
            //Current password and new password are same
            return redirect()->back()->withErrors("New Password cannot be same as your current password. Please choose a different password.");
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();

        $managers = User::whereHas(
            'roles', function($q){
            $q->where('name', 'manager');
        }
        )->get();

        // Send notification
        foreach ($managers as $manager)
            $manager->notify(new NotifUpdatePass($user));


        Session::flash("success", "Password changed successfully !");
        return redirect()->back();
    }
}
