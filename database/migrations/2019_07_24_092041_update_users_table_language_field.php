<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableLanguageField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('language', ['en', 'ua', 'ru'])->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('language', ['en', 'ua'])->after('id');
        });
    }
}
