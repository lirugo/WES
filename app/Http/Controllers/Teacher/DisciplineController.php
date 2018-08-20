<?php

namespace App\Http\Controllers\Teacher;

use App\Discipline;
use App\User;
use App\UserDiscipline;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisciplineController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id){
        $teacher = User::find($id);
        $discipline = Discipline::find($request->discipline);
        $disc = new UserDiscipline([
            'user_id' => $teacher->id,
            'discipline_id' => $request->discipline,
        ]);
        $disc->save();

        Session::flash('success', 'Discipline was successfully added.');
        return back();

    }
}
