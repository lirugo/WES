<?php

namespace App\Http\Controllers\Student;

use App\Http\Requests\StoreUserStudent;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Session;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('student.create');
    }

    public function store(StoreUserStudent $request){
        // Persist to db
        $user = new User();
        $user = $user->storeStudent($request);
        // Get role student
        $student = Role::where('name', 'student')->first();
        // Add role
        $user->attachRole($student);
        // Show flash msg
        Session::flash('success', 'Student was successfully created.');
        // Redirect to manage page
        return redirect(url('/manage'));
    }
}
