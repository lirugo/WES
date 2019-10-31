<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateGroupWorksSubteamsChats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE teams_group_works_sub_teams_chats MODIFY COLUMN text TEXT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE teams_group_works_sub_teams_chats MODIFY COLUMN text VARCHAR(255)');
    }
}
