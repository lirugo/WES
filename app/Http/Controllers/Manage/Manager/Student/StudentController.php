<?php

namespace App\Http\Controllers\Manage\Manager\Student;

use App\Http\Requests\StoreUserStudent;
use App\Http\Controllers\Controller;
use App\User;
use Session;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('manage.manager.student.create');
    }

    public function store(StoreUserStudent $request){
        // Persist to db
            $user = new User();
            $user->storeStudent($request);
        // Show flash msg
        Session::flash('success', 'Student was successfully created.');
        // Redirect to manage page
        return redirect(url('/manage'));
    }
}
