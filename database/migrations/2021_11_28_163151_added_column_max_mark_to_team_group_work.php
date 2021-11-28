<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedColumnMaxMarkToTeamGroupWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams_group_works', function (Blueprint $table) {
            $table->integer('max_mark')->default(0)->after("finished");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams_group_works', function (Blueprint $table) {
            $table->dropColumn('max_mark');
        });
    }
}
