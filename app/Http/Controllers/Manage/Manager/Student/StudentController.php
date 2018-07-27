<?php

namespace App\Http\Controllers\Manage\Manager\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('manage.manager.student.create');
    }
}
