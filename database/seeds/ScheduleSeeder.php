<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['team_id' => 1, 'teacher_id' => 4, 'discipline_id' => 1, 'title'=>'Event 1', 'start_date'=>'2018-08-07 9:00:00', 'end_date'=>'2018-08-07 18:00:00'],
            ['team_id' => 1, 'teacher_id' => 4, 'discipline_id' => 1, 'title'=>'Event 2', 'start_date'=>'2018-08-08 9:00:00', 'end_date'=>'2018-08-08 18:00:00'],
            ['team_id' => 1, 'teacher_id' => 4, 'discipline_id' => 1, 'title'=>'Event 3', 'start_date'=>'2018-08-08 9:00:00', 'end_date'=>'2018-08-08 18:00:00'],
            ['team_id' => 1, 'teacher_id' => 4, 'discipline_id' => 1, 'title'=>'Event 4', 'start_date'=>'2018-08-10 9:00:00', 'end_date'=>'2018-08-10 18:00:00'],
        ];
        DB::table('schedules')->insert($data);
    }
}
