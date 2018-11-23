<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePretestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pretest_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pretest_question_id')->unsigned();
            $table->foreign('pretest_question_id')->references('id')->on('pretest_questions')->onDelete('cascade');
            $table->string('name');
            $table->boolean('is_answer')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pretest_answers');
    }
}
