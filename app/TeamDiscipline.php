<?php

namespace App;

use App\Models\Team\Pretest;
use Illuminate\Database\Eloquent\Model;

class TeamDiscipline extends Model
{
    protected $table = 'teams_disciplines';

    protected $guarded = ['id'];

    public function getDiscipline(){
        return $this->hasOne(Discipline::class, 'id', 'discipline_id');
    }

    public function getTeacher(){
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    public function team(){
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function getTasks(){
        return $this->hasMany(TeamTask::class, 'discipline_id', 'id')->where('team_id', '=', $this->team_id);
    }

    public function getHomeWork(){
        return TeamsHomeWork::where([
            ['team_id', $this->team_id],
            ['discipline_id', $this->discipline_id]
        ])->orderBy('id', 'DESC')->get();
    }

    public function getCountPoints(){
        $points = 0;
        foreach ($this->getTasks as $task)
            $points += $task->max_mark;
        return $points;
    }

    public function hasPretest(){
        return (bool) $this->hasMany(Pretest::class, 'discipline_id', 'discipline_id')->first();
    }

    public function pretests(){
        return $this->hasMany(Pretest::class, 'discipline_id', 'discipline_id');
    }

    /**
     * @DESC Get left count of lessons for teacher
     * @param int $teamId
     * @param int $teacherId
     * @param int $disciplineId
     * @return int
     */
    public function leftHours(int $teamId, int $teacherId, int $disciplineId) : int {
        //Get max hours for teacher
        $maxHours = TeamDiscipline::where([
            'team_id' => $teamId,
            'teacher_id' => $teacherId,
            'discipline_id' => $disciplineId,
        ])->first()->hours;

        //Get count of set lessons multiply on 3
        $lessonsHours = Schedule::where([
            'team_id' => $teamId,
            'teacher_id' => $teacherId,
            'discipline_id' => $disciplineId,
        ])->count() * 3;

        //Get left hours
        $leftHours = $maxHours - $lessonsHours;

        //Return different
        return $leftHours;
    }
}
