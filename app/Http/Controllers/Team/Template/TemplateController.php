<?php

namespace App\Http\Controllers\Team\Template;

use App\Discipline;
use App\Http\Requests\StoreTeamTemplate;
use App\Role;
use App\TeamTemplate;
use App\TeamTemplateDiscipline;
use App\TeamTemplateLessonTime;
use App\User;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
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
        $templates = TeamTemplate::all();
        return view('team.template.index')
            ->withTemplates($templates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('team.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTeamTemplate $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamTemplate $request)
    {
        // Persist
        $template = TeamTemplate::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);


        //TODO:: trash remake it lesson time
        TeamTemplateLessonTime::create([
            'template_id' => $template->id,
            'position' => 1,
            'start_time' => $request->startTime_1,
            'end_time' => $request->endTime_1,
        ]);
        if($request->startTime_2 && $request->startTime_2)
            TeamTemplateLessonTime::create([
                'template_id' => $template->id,
                'position' => 2,
                'start_time' => $request->startTime_2,
                'end_time' => $request->endTime_2,
            ]);
        if($request->startTime_3 && $request->startTime_3)
            TeamTemplateLessonTime::create([
                'template_id' => $template->id,
                'position' => 3,
                'start_time' => $request->startTime_3,
                'end_time' => $request->endTime_3,
            ]);
        if($request->startTime_4 && $request->startTime_4)
            TeamTemplateLessonTime::create([
                'template_id' => $template->id,
                'position' => 4,
                'start_time' => $request->startTime_4,
                'end_time' => $request->endTime_4,
            ]);

        // Show flash msg
        Session::flash('success', 'Team template was successfully created.');

        // Return to manage
        return redirect(url('/team/template/'.$template->name.'/edit'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        // Get template
        $template = TeamTemplate::where('name', $name)->first();

        // Get all teachers
        $teachers = User::whereRoleIs('teacher')->get();

        // Get all disciplines
        $disciplines = Discipline::all();

        return view('team.template.edit')
            ->withTemplate($template)
            ->withTeachers($teachers)
            ->withDisciplines($disciplines);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

    /**
     * Add Teacher with Discipline with Hour to Template of Group
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function teacher(Request $request, $teamName){
        // Find teacher
        $user = User::find($request->teacher);

        // Find template
        $team = TeamTemplate::where('name', $teamName)->first();

        // Find role teacher
        $teacher = Role::where('name', 'teacher')->first();

        // Check on duplicate discipline
        foreach ($team->disciplines as $discipline)
            if($discipline->discipline_id == $request->teacher_discipline)
            {
                // Return back with error message
                return back()->withErrors(['Current discipline already exist in group template']);
            }

        // Add discipline to team
        $discipline = TeamTemplateDiscipline::create([
            'template_id' => $team->id,
            'teacher_id' => $user->id,
            'discipline_id' => $request->teacher_discipline,
            'hours' => $request->hours
        ]);

        // Show flash msg
        Session::flash('success', 'Teacher was successfully added to group template.');

        // Return to manage
        return back();
    }

    public function disciplineDelete($team, $discipline){
//        // Find teacher
//        $user = User::find($teacher);
//
//        // Find template
//        $template = TeamTemplate::find($team);

        // Find Discipline
        $discipline = TeamTemplateDiscipline::where([
            ['template_id', $team],
            ['discipline_id', $discipline],
        ])->delete();

        // Show flash msg
        Session::flash('success', 'Discipline was successfully deleted form group template.');

        // Return to manage
        return back();
    }
}
