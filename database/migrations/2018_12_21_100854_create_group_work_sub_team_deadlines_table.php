<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupWorkSubTeamDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_group_works_sub_teams_deadlines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subteam_id')->unsigned();
            $table->foreign('subteam_id')->references('id')->on('teams_group_works_sub_teams')->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
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
        Schema::dropIfExists('teams_group_works_sub_teams_deadlines');
    }
}
