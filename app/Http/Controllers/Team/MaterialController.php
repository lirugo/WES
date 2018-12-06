<?php

namespace App\Http\Controllers\Team;

use App\Discipline;
use App\Http\Controllers\Controller;
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

    public function create($team){
        $team = Team::where('name', $team)->first();
        return view('team.material.create')
            ->withTeam($team);
    }

    public function store(Request $request, $name)
    {
        $team = Team::where('name', $name)->first();
        $discipline = Discipline::find($request->discipline_id);

        foreach (json_decode($request->inputs) as $file)
            TeamMaterials::create([
                'user_id' => Auth::user()->id,
                'team_id' => $team->id,
                'discipline_id' => $discipline->id,
                'name' => $file->file,
                'file' => $file->nameFormServer,
            ]);

        Session::flash('success', 'Education material was be successfully created');
        return redirect(url('/team/'.$team->name.'/material'));
    }

    public function storeFile(Request $request, $name)
    {
        if ($request->hasFile('file')) {
            $filePath = Storage::disk('material')->put('/', $request->file);
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

        return view('team.material.show')
            ->withTeam($team)
            ->withDiscipline($discipline)
            ->withMaterials($materials);

    }

    public function getFile($name){
        $file = TeamMaterials::where('file', $name)->first();
        $path = storage_path('/app/material/'.$name);
        $info = pathinfo($path);

        return response()->download($path, $file->name.'.'.$info['extension']);
    }
}
