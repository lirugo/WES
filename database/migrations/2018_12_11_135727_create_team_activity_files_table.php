<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamActivityFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_activity_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('answer_id')->unsigned()->nullable();
            $table->foreign('answer_id')->references('id')->on('team_activity_user_answers')->onDelete('cascade');
            $table->integer('reply_id')->unsigned()->nullable();
            $table->foreign('reply_id')->references('id')->on('team_activity_reply_on_user_answers')->onDelete('cascade');
            $table->integer('activity_id')->unsigned()->nullable();;
            $table->foreign('activity_id')->references('id')->on('team_activities')->onDelete('cascade');
            $table->string('name');
            $table->string('file');
            $table->enum('type', ['activity', 'answer', 'reply']);
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
        Schema::dropIfExists('team_activity_files');
    }
}
