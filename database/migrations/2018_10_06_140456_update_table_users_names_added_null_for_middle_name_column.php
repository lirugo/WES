<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUsersNamesAddedNullForMiddleNameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_names', function(Blueprint $table)
        {
            DB::statement('ALTER TABLE users_names CHANGE COLUMN middle_name middle_name VARCHAR(255) NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_names', function(Blueprint $table)
        {
            DB::statement('ALTER TABLE users_names CHANGE COLUMN middle_name middle_name VARCHAR(255) NOT NULL;');
        });
    }
}
