<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupWorkSubTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_group_works_sub_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_work_id')->unsigned()->nullable();
            $table->foreign('group_work_id')->references('id')->on('teams_group_works')->onDelete('cascade');
            $table->string('name');
            $table->boolean('finished')->default(false);
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
        Schema::dropIfExists('teams_group_works_sub_teams');
    }
}
