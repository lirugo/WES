<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Models\Team\GroupWork;
use App\Models\Team\GroupWorkSubTeamMembers;
use App\Models\Team\TeamActivity;
use App\Models\Team\TeamActivityMark;
use App\Notifications\Team\NotifNewActivityMark;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Session;

class TeamApiController extends Controller
{
    public function updateActivityMark(Request $request){
        if(!Auth::user()->hasRole('student')){
            $student = User::find($request->studentId);
            $activity = TeamActivity::find($request->activityId);
            $activityMark = TeamActivityMark::
                where('type', 'activity')
                ->where('student_id', $request->studentId)
                ->where('activity_id', $request->activityId)
                ->first();
            if($activityMark == null){
                $activityMark = TeamActivityMark::create([
                    'type' => 'activity',
                    'student_id' => $request->studentId,
                    'activity_id' => $request->activityId,
                    'mark' => $request->mark
                ]);
            }else{
                $activityMark->mark = $request->mark;
                $activityMark->save();
            }

            //Send notification
            $student->notify(new NotifNewActivityMark($activity, $student));
        }else {
            return 'DENIED';
        }

        return 'OK';
    }

    public function updatePretestMark(Request $request){
        if(!Auth::user()->hasRole('student')){
            $student = User::find($request->studentId);
            $activity = TeamActivity::find($request->activityId);

            $activityMark = TeamActivityMark::
                where('type', 'pretest')
                ->where('student_id', $request->studentId)
                ->where('activity_id', $request->activityId)
                ->first();
            if($activityMark == null){
                $activityMark = TeamActivityMark::create([
                    'type' => 'pretest',
                    'student_id' => $request->studentId,
                    'activity_id' => $request->activityId,
                    'mark' => $request->mark
                ]);
            }else{
                $activityMark->mark = $request->mark;
                $activityMark->save();
            }
        }else {
            return 'DENIED';
        }

        return 'OK';
    }

    public function updateGroupWorkMark(Request $request){
        if(!Auth::user()->hasRole('student')){
            $groupWork = GroupWork::find($request->activityId);
            $subTeam = $groupWork->getSubTeam($request->studentId);

            $member = GroupWorkSubTeamMembers::where([
                'subteam_id' => $subTeam->id,
                'user_id' => $request->studentId
            ])->first();

            if($member == null){
                $member = GroupWorkSubTeamMembers::create([
                    'subteam_id' => $request->activityId,
                    'user_id' => $request->studentId,
                    'mark' => $request->mark,
                ]);
            }else{
                $member->mark = $request->mark;
                $member->save();
            }

        }else {
            return 'DENIED';
        }

        return 'OK';
    }
}
