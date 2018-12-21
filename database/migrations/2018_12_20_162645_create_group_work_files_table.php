<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupWorkFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_group_works_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_work_id')->unsigned()->nullable();
            $table->foreign('group_work_id')->references('id')->on('teams_group_works')->onDelete('cascade');
            $table->integer('subteam_id')->unsigned()->nullable();
            $table->foreign('subteam_id')->references('id')->on('teams_group_works_sub_teams')->onDelete('cascade');
            $table->integer('chat_id')->unsigned()->nullable();
            $table->foreign('chat_id')->references('id')->on('teams_group_works_sub_teams_chats')->onDelete('cascade');
            $table->string('name');
            $table->string('file');
            $table->enum('type', ['group-work', 'sub-team', 'chat']);
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
        Schema::dropIfExists('teams_group_works_files');
    }
}
