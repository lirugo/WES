<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('change_logs', function (Blueprint $table) {
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('users');
            $table->integer('target_id')->unsigned();
            $table->string('type')->nullable();
            $table->text('old')->nullable();
            $table->text('new')->nullable();
            $table->dropUnique('change_logs_title_unique');
        });
        DB::statement('ALTER TABLE `change_logs` MODIFY `body` TEXT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('change_logs', function (Blueprint $table) {
            $table->dropForeign('change_logs_author_id_foreign');
            $table->dropColumn('author_id');
            $table->dropColumn('target_id');
            $table->dropColumn('type');
            $table->dropColumn('old');
            $table->dropColumn('new');
            $table->unique('title');
        });
        DB::statement('ALTER TABLE `change_logs` MODIFY `body` TEXT NOT NULL;');
    }
}
