<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Team\TeamActivity;
use Auth;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $allActivity = collect();
        $teams = Auth::user()->teams();
        $disciplines = collect();
        foreach($teams as $team){
            $activities = TeamActivity::where('team_id', $team->id)->orderBy('id', 'DESC')->get()->map(function($activity) {
                $activity->link = url('/team/'.$activity->team->name.'/activity/'.$activity->discipline->name.'/pass/'.$activity->id.'/'.Auth::user()->id);
                $activity->mark = $activity->getMark(Auth::user()->id) ? $activity->getMark(Auth::user()->id)->mark : '';
                $activity->type_full = $activity->getType();

                return $activity;
            });
            foreach($activities as $activity){
                $disciplines->push($activity->discipline);
            }
            $allActivity = $allActivity->merge($activities);
        }

        $disciplines = $disciplines->unique('id')->values();
        return view('manage.index')
            ->withTeams($teams)
            ->withActivities($allActivity)
            ->withDisciplines($disciplines);
    }
}
