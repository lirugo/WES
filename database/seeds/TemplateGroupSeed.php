<?php

use Illuminate\Database\Seeder;

class TemplateGroupSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams_templates')->insert([
            'display_name' => 'MBA',
            'name' => 'mba',
        ]);

        DB::table('teams_template_disciplines')->insert([
            'template_id' => 1,
            'teacher_id' => 4,
            'discipline_id' => 1,
            'hours' => 80,
        ]);
        DB::table('teams_template_disciplines')->insert([
            'template_id' => 1,
            'teacher_id' => 4,
            'discipline_id' => 2,
            'hours' => 90,
        ]);
    }
}
