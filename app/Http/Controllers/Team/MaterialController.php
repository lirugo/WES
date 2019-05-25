<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\EducationMaterial\Category;
use App\Models\Team\EducationMaterial\EducationMaterial;
use App\Models\Team\TeamMaterials;
use App\Team;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function index($team)
    {
        $team = Team::where('name', $team)->first();

        if(Auth::user()->hasRole('teacher'))
            $disciplines = Auth::user()->getTeacherDiscipline($team->name);
        else
            $disciplines = $team->disciplines;

        return view('team.material.index')
            ->withTeam($team)
            ->withDisciplines($disciplines);
    }

    public function create($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $categories = Category::where('team_id', $team->id)->where('discipline_id', $discipline->id)->orderBy('name')->get();
        return view('team.material.create')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withCategories($categories);
    }

    public function categoryCreate($team, $discipline){
        if(Auth::user()->hasRole('student'))
            abort(403);

        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        return view('team.material.categoryCreate')
            ->withTeam($team)
            ->withDiscipline($discipline);
    }

    public function store(Request $request, $team, $discipline)
    {
        if(Auth::user()->hasRole('student'))
            abort(403);

        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $category = Category::find($request->category_id);

        //Save file
        $filePath = Storage::disk('material')->put(DIRECTORY_SEPARATOR, $request->file);
        $fileName = basename($filePath);
        //Save record to db
        EducationMaterial::create([
            'user_id' => auth()->id(),
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'category_id' => $category->id,
            'name' => $request->name,
            'type' => $request->name == 'on' ? 'public' : 'staff',
            'file_name' => $fileName,
        ]);

        Session::flash('success', 'Education material was be successfully created');
        return redirect(url('/team/'.$team->name.'/material'));
    }

    public function categoryStore(Request $request, $team, $discipline)
    {
        if(Auth::user()->hasRole('student'))
            abort(403);

        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();

        Category::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'user_id' => auth()->id(),
            'name' => $request->name,
        ]);

        Session::flash('success', 'Education material category was be successfully created');
        return redirect(url('/team/'.$team->name.'/material/'.$discipline->name));
    }

    public function storeFile(Request $request, $name)
    {
        if ($request->hasFile('file')) {
            $filePath = Storage::disk('material')->put(DIRECTORY_SEPARATOR, $request->file);
            return basename($filePath);
        } else
            return false;

    }

    public function show($team, $discipline){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $materials = TeamMaterials::where([
            ['team_id', $team->id],
            ['discipline_id', $discipline->id],
        ])->orderBy('id','DESC')->get();
        $categories = Category::where('team_id', $team->id)->where('discipline_id', $discipline->id)->orderBy('name')->get();

        return view('team.material.show')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withMaterials($materials)
            ->withCategories($categories);

    }

    public function getFile($name){
        $file = TeamMaterials::where('file', $name)->first();
        $path = storage_path('/app/material/'.$name);
        $info = pathinfo($path);

        return response()->download($path, $file->name.'.'.$info['extension']);
    }

    public function delete($id){
        TeamMaterials::find($id)->delete();

        Session::flash('success', 'Education material was be successfully deleted');
        return back();
    }
}
