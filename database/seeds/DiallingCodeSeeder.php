<?php

use Illuminate\Database\Seeder;

class DiallingCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(config('dialling_code') as $key => $name){
            DB::table('dialling_codes')->insert([
                'name' => $name,
                'dialling_code' => $key,
            ]);
        }

    }
}
