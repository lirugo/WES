<?php

namespace App\Http\Controllers\Student;

use App\Discipline;
use App\Exports\StudentMarkDisciplineExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExportStudentMarkRequest;
use App\Http\Requests\StoreUserStudent;
use App\Http\Requests\UpdateUserStudent;
use App\Models\Team\GroupWork;
use App\Models\Team\Pretest;
use App\Models\Team\TeamActivity;
use App\Role;
use App\Team;
use App\User;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class StudentController extends Controller
{
  public function __construct()
  {
    $this->middleware('role:administrator|top-manager|manager');
  }

  public function index()
  {
    $students = User::whereRoleIs('student')->get();
    foreach ($students as $key => $student) {
      if (count($student->teams()) != 0)
        unset($students[$key]);
    }

    return view('student.index')->withStudents($students);
  }

  public function create()
  {
    return view('student.create');
  }

  public function show($id)
  {
    $student = User::find($id);
    $teams = $student->teams();
    return view('student.show')
      ->withStudent($student)
      ->withTeams($teams);
  }

  public function store(StoreUserStudent $request)
  {
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

  public function export(ExportStudentMarkRequest $request)
  {
    $user = User::find($request->student_id);
    $team = Team::find($request->team_id);
    $discipline_name = $request->discipline_id != -1 ? Discipline::find($request->discipline_id)->display_name : 'All';
    $file_name = $user->getFullName() . '-' . $team->display_name . '-' . $discipline_name . '.xlsx';
    if ($request->discipline_id == -1) {
      $activities = TeamActivity::where([
        'team_id' => $team->id,
        'mark_in_journal' => true,
      ])->orderBy('discipline_id', 'ASC')->get();
      $groupWorks = GroupWork::where([
        'team_id' => $team->id,
      ])->orderBy('discipline_id', 'ASC')->get();
      $preTests = Pretest::where([
        'team_id' => $team->id,
      ])->orderBy('discipline_id', 'ASC')->get();
    } else {
      $activities = TeamActivity::where([
        'team_id' => $team->id,
        'discipline_id' => $request->discipline_id,
        'mark_in_journal' => true,
      ])->orderBy('discipline_id', 'ASC')->get();
      $groupWorks = GroupWork::where([
        'team_id' => $team->id,
        'discipline_id' => $request->discipline_id
      ])->orderBy('discipline_id', 'ASC')->get();
      $preTests = Pretest::where([
        'team_id' => $team->id,
        'discipline_id' => $request->discipline_id
      ])->orderBy('discipline_id', 'ASC')->get();
    }
    return Excel::download(new StudentMarkDisciplineExport($team, $user, $discipline_name, $activities, $groupWorks, $preTests), $file_name);
  }

  public function update(UpdateUserStudent $request, $id)
  {
    //Find student
    $student = User::find($id);
    $student->updateStudent($request);
    // Show flash msg
    Session::flash('success', 'Student was successfully updated.');
    // Redirect to manage page
    return back();
  }
}
