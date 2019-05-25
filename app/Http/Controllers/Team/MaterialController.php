<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Models\Team\EducationMaterial\Category;
use App\Models\Team\EducationMaterial\EducationMaterial;
use App\Models\Team\EducationMaterial\Link;
use App\Models\Team\EducationMaterial\Video;
use App\Models\Team\TeamMaterials;
use App\Team;
use Auth;
use Carbon\Carbon;
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

    public function edit($team, $discipline, $fileId){
        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $categories = Category::where('team_id', $team->id)->where('discipline_id', $discipline->id)->orderBy('name')->get();
        $material = EducationMaterial::find($fileId);

        return view('team.material.edit')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withCategories($categories)
            ->withMaterial($material);
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

    public function linkCreate($team, $discipline){
        if(Auth::user()->hasRole('student'))
            abort(403);

        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        return view('team.material.linkCreate')
            ->withTeam($team)
            ->withDiscipline($discipline);
    }

    public function videoCreate ($team, $discipline){
        if(Auth::user()->hasRole('student'))
            abort(403);

        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        return view('team.material.videoCreate ')
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
        $filePath = Storage::disk('material')->put('/', $request->file);
        $fileName = basename($filePath);
        //Save record to db
        EducationMaterial::create([
            'user_id' => auth()->id(),
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'category_id' => $category->id,
            'name' => $request->name,
            'type' => $request->type == 'on' ? 'public' : 'staff',
            'file_name' => $fileName,
            'public_date' => $request->public_date,
        ]);

        Session::flash('success', 'Education material was be successfully created');
        return redirect(url('/team/'.$team->name.'/material/'.$discipline->name));
    }

    public function update(Request $request, $team, $discipline, $fileId)
    {
        if(Auth::user()->hasRole('student'))
            abort(403);

        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();
        $category = Category::find($request->category_id);
        $material = EducationMaterial::find($fileId);

        $material->public_date = $request->public_date;
        $material->type = $request->type == 'on' ? 'public' : 'staff';
        $material->save();

        Session::flash('success', 'Education material was be successfully updated');
        return redirect(url('/team/'.$team->name.'/material/'.$discipline->name));
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

    public function linkStore(Request $request, $team, $discipline)
    {
        if(Auth::user()->hasRole('student'))
            abort(403);

        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();

        Link::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'link' => $request->link,
            'public_date' => $request->public_date,
        ]);

        Session::flash('success', 'Education material link was be successfully created');
        return redirect(url('/team/'.$team->name.'/material/'.$discipline->name));
    }

    public function videoStore(Request $request, $team, $discipline)
    {
        if(Auth::user()->hasRole('student'))
            abort(403);

        $team = Team::where('name', $team)->first();
        $discipline = Discipline::where('name', $discipline)->first();

        Video::create([
            'team_id' => $team->id,
            'discipline_id' => $discipline->id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'link' => $request->link,
            'public_date' => $request->public_date,
        ]);

        Session::flash('success', 'Education material link was be successfully created');
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
        $links = Link::where('team_id', $team->id)->where('discipline_id', $discipline->id)
            ->orderBy('name');

        if(Auth::user()->hasRole('teacher'))
            $links = $links->get();
        else
            $links = $links->where('public_date', '<', Carbon::now())->get();

        $videos = Video::where('team_id', $team->id)->where('discipline_id', $discipline->id)->get();

        return view('team.material.show')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withMaterials($materials)
            ->withCategories($categories)
            ->withLinks($links)
            ->withVideos($videos);
    }

    public function getFile($name){
        $file = TeamMaterials::where('file', $name)->first();
        $path = storage_path('/app/material/'.$name);
        $info = pathinfo($path);

        return response()->download($path, $file->name.'.'.$info['extension']);
    }

    public function getMaterialFile($name){
        $file = EducationMaterial::where('file_name', $name)->first();
        $path = storage_path('/app/material/'.$name);
        $info = pathinfo($path);

        return response()->download($path, $file->name.'.'.$info['extension']);
    }

    public function delete($id){
        EducationMaterial::find($id)->delete();

        Session::flash('success', 'Education material was be successfully deleted');
        return back();
    }

    public function linkDelete($id){
        Link::find($id)->delete();

        Session::flash('success', 'Education material link was be successfully deleted');
        return back();
    }

    public function videoDelete($id){
        Video::find($id)->delete();

        Session::flash('success', 'Education material link was be successfully deleted');
        return back();
    }
}
