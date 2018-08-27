<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests\StoreUserManager;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $managers = User::whereRoleIs('manager')->get();
        return view('manager.index')
            ->withManagers($managers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserManager $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserManager $request)
    {
        // Persist to db
        $user = new User();
        $user = $user->storeManager($request);
        // Get role student
        $manager = Role::where('name', 'manager')->first();
        // Add role
        $user->attachRole($manager);
        // Show flash msg
        Session::flash('success', 'Manager was successfully created.');
        // Redirect to manage page
        return redirect(url('/manager'));
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
