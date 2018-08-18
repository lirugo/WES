<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DiallingCodeSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(DisciplinesSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(TemplateGroupSeed::class);
    }
}
