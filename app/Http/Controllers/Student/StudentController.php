<?php

namespace App\Http\Controllers\Student;

use App\Http\Requests\StoreUserStudent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserStudent;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Session;
use Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager');
    }

    public function index(){
        $students = User::whereRoleIs('student')->get();
        return view('student.index')->withStudents($students);
    }

    public function create(){
        return view('student.create');
    }

    public function show($id){
        $student = User::find($id);
        return view('student.show')->withStudent($student);
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
        return redirect(url('/student'));
    }

    public function update(UpdateUserStudent $request, $id){
        //Find student
        $student = User::find($id);
        $student->updateStudent($request);
        // Show flash msg
        Session::flash('success', 'Student was successfully updated.');
        // Redirect to manage page
        return back();
    }

    public function updateAvatar(Request $request, $id){
        if($request->hasFile('avatar')){
            $file = $request->avatar;

            $destinationPath = public_path() . '/uploads/avatars/';
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $filename);

            $student = User::find($id);
            $student->avatar = $filename;
            $student->save();

            return json_encode(['status' => 'OK', 'avatar' => $filename]);
        }
    }
}
