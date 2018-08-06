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
            'name' => 'Mathematics',
            'description' => 'Mathematics Description',
        ]);
        DB::table('disciplines')->insert([
            'name' => 'English',
            'description' => 'English Description',
        ]);
        DB::table('disciplines')->insert([
            'name' => 'Management',
            'description' => 'Management Description',
        ]);
    }
}
