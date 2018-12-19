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
        Schema::create('team_group_work_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_work_id')->unsigned()->nullable();
            $table->foreign('group_work_id')->references('id')->on('teams_group_works')->onDelete('cascade');
//            $table->integer('subteam_id')->unsigned()->nullable();;
//            $table->foreign('subteam_id')->references('id')->on('teams_group_works_subteam')->onDelete('cascade');
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
        Schema::dropIfExists('team_group_work_files');
    }
}
