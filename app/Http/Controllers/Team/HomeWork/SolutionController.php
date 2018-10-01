<?php

namespace App\Http\Controllers\Team\HomeWork;

use App\Discipline;
use App\Http\Requests\UpdateHomeWorkSolution;
use App\Team;
use App\TeamsHomeWork;
use App\TeamsHomeWorkFile;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Http\Controllers\Controller;

class SolutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:administrator|top-manager|manager|teacher|student');
    }

    public function edit($team, $discipline, $homeWork){
        // Get team
        $team = Team::where('name',$team)->first();

        // Get discipline
        $discipline = Discipline::where('name', $discipline)->first();

        // Get HomeWork
        $homeWork = TeamsHomeWork::where('name', $homeWork)->first();

        // Validate Access
        if(Carbon::now() > $homeWork->assignment_date)
            abort(403);
        if($homeWork->getSolution() == null)
            abort(403);
        elseif($homeWork->getSolution()->student_id != Auth::user()->id)
            abort(403);

        // Return view
        return view('team.homework.solution.edit')
            ->withDiscipline($team->getDiscipline($discipline->id))
            ->withTeam($team)
            ->withHomeWork($homeWork);
    }

    public function update(UpdateHomeWorkSolution $request, $team, $discipline, $homeWork){
        // Get team
        $team = Team::where('name',$team)->first();

        // Get discipline
        $discipline = Discipline::where('name', $discipline)->first();

        // Get HomeWork
        $homeWork = TeamsHomeWork::where('name', $homeWork)->first();

        // Get Solution
        $homeWork->getSolution()->update(['display_name' => $request->display_name, 'description' => $request->description]);

        // Save file if exist
        if($request->hasFile('file'))
        {
            TeamsHomeWorkFile::where([
                ['team_id', $team->id],
                ['homework_id', $homeWork->id],
                ['student_id', Auth::user()->id],
                ['status', 'solution'],
            ])->delete();

            foreach ($request->file as $f) {
                $filePath = Storage::disk('homework')->put('/task', $f);
                TeamsHomeWorkFile::create([
                    'team_id' => $team->id,
                    'homework_id' => $homeWork->id,
                    'student_id' => Auth::user()->id,
                    'status' => 'solution',
                    'name' => basename($filePath),
                ]);
            }
            // Trigger updated_at timestamp
            $homeWork->getSolution()->update(['updated_at' => Carbon::now()]);
        }

        // Flash message
        Session::flash('success', 'Solution for homework was successfully updated');
        // Redirect back
        return redirect(url('/team/'.$team->name.'/homework/'.$discipline->name.'/'.$homeWork->name));
    }
}
