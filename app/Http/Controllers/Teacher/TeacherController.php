<?php

namespace App\Http\Controllers\Teacher;

use App\Discipline;
use App\Http\Requests\StoreUserTeacher;
use App\Role;
use App\User;
use App\TeamDiscipline;
use App\UserDiscipline;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
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
        Session::flash('success', 'Student was successfully created.');

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
        $teacher = User::find($id);
        $disciplines = Discipline::all();
        return view('teacher.edit')
            ->withTeacher($teacher)
            ->withDisciplines($disciplines);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserTeacher $request
     * @param  int $id
     * @return void
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
