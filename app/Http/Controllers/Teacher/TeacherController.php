<?php

namespace App\Http\Controllers\Teacher;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserTeacher;
use App\Http\Requests\UpdateUserTeacher;
use App\Role;
use App\User;
use App\UserDiscipline;
use Session;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = User::whereRoleIs('teacher')->get();
        return view('teacher.index')->withTeachers($teachers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $disciplines = Discipline::all();
        return view('teacher.create')
            ->withDisciplines($disciplines);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserTeacher $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserTeacher $request)
    {
        // Persist to db
        $user = new User();
        $user = $user->storeTeacher($request);

        // Add discipline
        foreach($request->disciplines as $discipline){
            UserDiscipline::create([
                'user_id' => $user->id,
                'discipline_id' => $discipline
            ]);
        }

        // Get role student
        $teacher = Role::where('name', 'teacher')->first();

        // Add role
        $user->attachRole($teacher);

        // Show flash msg
        Session::flash('success', 'Teacher was successfully created.');

        // Redirect to manage page
        return redirect(url('/manage'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = User::find($id);
        return view('teacher.show')->withTeacher($teacher);
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
     * @param StoreUserTeacher $request
     * @param  int $id
     * @return void
     */
    public function update(UpdateUserTeacher $request, $id)
    {

        //Find student
        $teacher = User::find($id);
        $teacher->updateTeacher($request);
        // Show flash msg
        Session::flash('success', 'Teacher was successfully updated.');
        // Redirect to manage page
        return back();
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
