<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamEducationMaterialCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_education_material_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedInteger('discipline_id');
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');

            $table->string('name');

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
        Schema::dropIfExists('team_education_material_category');
    }
}
