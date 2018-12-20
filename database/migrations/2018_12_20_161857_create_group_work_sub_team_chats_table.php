<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupWorkSubTeamChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_group_works_sub_teams_chats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subteam_id')->unsigned();
            $table->foreign('subteam_id')->references('id')->on('teams_group_works_sub_teams')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams_group_works_sub_teams_chats');
    }
}
