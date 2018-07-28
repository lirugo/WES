<?php

namespace App\Http\Controllers\Manage\Manager\Student;

use App\Http\Requests\StoreUserStudent;
use App\Http\Controllers\Controller;
use App\User;

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
        // Validate
        // Persist to db
            $user = new User();
            $user->storeStudent($request);
        // Show flash msg
        // Redirect to manage page
        dd($request->all());
    }
}
