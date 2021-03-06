<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamVideoLessonsTable extends Migration
{
    public function up()
    {
        Schema::create('team_video_lessons', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('team_discipline_id');
            $table->foreign('team_discipline_id')->references('id')->on('teams_disciplines')->onDelete('cascade');

            $table->string('file_name');
            $table->text('description');
            $table->string('module');
            $table->integer('part');
            $table->boolean('public');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('date');

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
        Schema::dropIfExists('team_video_lessons');
    }
}
