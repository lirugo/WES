<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamActivityMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_activity_marks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('team_activities')->onDelete('cascade');
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('mark');
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
        Schema::dropIfExists('team_activity_marks');
    }
}
