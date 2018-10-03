<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSocial;
use App\UserSocial;
use Illuminate\Http\Request;
use Session;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StoreSocial $request, $id)
    {
        $social = UserSocial::where([
            ['user_id', $id],
            ['name', $request->name],
        ])->first();
        if(!is_null($social)){
            return back()->withErrors('Social link already exists');
        }

        UserSocial::create([
            'user_id' => $id,
            'name' => $request->name,
            'url' => $request->url,
        ]);

        Session::flash('success', 'Social was be added');
        return back();
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
    public function delete($socialId)
    {
        UserSocial::find($socialId)->delete();
        Session::flash('success', 'Social was be deleted');
        return back();
    }
}
