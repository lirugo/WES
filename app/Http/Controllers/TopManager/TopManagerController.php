<?php

namespace App\Http\Controllers\TopManager;

use App\Http\Requests\StoreUserManager;
use App\Role;
use App\User;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topManagers = User::whereRoleIs('top-manager')->get();
        return view('top-manager.index')
            ->withTopManagers($topManagers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('top-manager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserManager $request)
    {
        // Persist to db
        $user = new User();
        $user = $user->storeTopManager($request);
        // Get role student
        $manager = Role::where('name', 'top-manager')->first();
        // Add role
        $user->attachRole($manager);
        // Show flash msg
        Session::flash('success', 'Top-Manager was successfully created.');
        // Redirect to manage page
        return redirect(url('/top-manager'));
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
}
