<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name' => 'financial_management',
            'display_name' => 'Financial management',
        ]);
        DB::table('tags')->insert([
            'name' => 'management_accounting',
            'display_name' => 'Management Accounting',
        ]);
    }
}
