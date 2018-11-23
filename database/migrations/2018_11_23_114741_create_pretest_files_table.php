<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePretestFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pretest_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pretest_id')->unsigned();
            $table->foreign('pretest_id')->references('id')->on('pretests')->onDelete('cascade');
            $table->string('name');
            $table->string('file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pretest_files');
    }
}
