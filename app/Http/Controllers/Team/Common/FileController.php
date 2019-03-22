<?php

namespace App\Http\Controllers\Team\Common;

use App\Models\Team\CommonFile;
use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Session;

class FileController extends Controller
{
    public function create($team){
        $team = Team::where('name', $team)->first();

        return view('team.common.file.create')
            ->withTeam($team);
    }

    public function store(Request $request, $team){
        $team = Team::where('name', $team)->first();


        $commonFile = new CommonFile();
        $commonFile->team_id = $team->id;
        $commonFile->title = $request->title;
        $filePath = Storage::disk('common-file')->put('/', $request->file);
        $commonFile->file =  basename($filePath);
        $commonFile->save();

        Session::flash('success', "File was be saved");
        return redirect(url('/team/'.$team->name));
    }

    public function getFile($team, $file){
        $common = CommonFile::where('file', $file)->first();
        $path = storage_path('/app/common-file/'.$file);
        $info = pathinfo($path);

        return response()->download($path, $common->title.'.'.$info['extension']);
    }
}
