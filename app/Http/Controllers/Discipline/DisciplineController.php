<?php

namespace App\Http\Controllers\Discipline;

use App\Discipline;
use App\Http\Requests\StoreDiscipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disciplines = Discipline::all();
        return view('discipline.index')->withDisciplines($disciplines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discipline.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscipline $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscipline $request)
    {
        // Persist
        $discipline = Discipline::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        // Show flash msg
        Session::flash('success', 'Discipline was successfully created.');

        // Return to manage
        return redirect(url('/discipline'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        $discipline = Discipline::where('name', $name)->first();
        return view('discipline.edit')->withDiscipline($discipline);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name)
    {
        // Update in database
        $discipline = Discipline::where('name', $name)->first();
        $discipline->display_name = $request->display_name;
        $discipline->description = $request->description;
        $discipline->save();

        // Show flash msg
        Session::flash('success', 'Discipline was successfully updated.');
        return redirect(url('discipline'));
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
