<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserSettingNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_setting_notifications', function (Blueprint $table) {
            //SMS
            $table->boolean('sms_new_group_work')->defailt(false)->after('sms_new_mark');

            //EMAIL
            $table->boolean('email_new_group_work')->defailt(false)->after('email_new_mark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_setting_notifications', function (Blueprint $table) {
            //SMS
            $table->dropColumn('sms_new_group_work');

            //EMAIL
            $table->dropColumn('email_new_group_work');
        });
    }
}
