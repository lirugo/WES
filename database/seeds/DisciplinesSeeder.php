<?php

use Illuminate\Database\Seeder;

class DisciplinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disciplines')->insert([
            'display_name' => 'Mathematics',
            'name' => 'mathematics',
            'description' => 'Mathematics Description',
        ]);
        DB::table('disciplines')->insert([
            'display_name' => 'English',
            'name' => 'english',
            'description' => 'English Description',
        ]);
        DB::table('disciplines')->insert([
            'display_name' => 'Management',
            'name' => 'management',
            'description' => 'Management Description',
        ]);
    }
}
