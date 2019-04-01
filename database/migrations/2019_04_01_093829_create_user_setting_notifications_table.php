<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSettingNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_setting_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //SMS
            $table->boolean('sms_new_mark')->defailt(false);
            $table->boolean('sms_new_chat_message')->defailt(false);
            $table->boolean('sms_new_activity')->defailt(false);
            $table->boolean('sms_new_test')->defailt(false);
            $table->boolean('sms_update_schedule')->defailt(false);
            $table->boolean('sms_update_activity')->defailt(false);

            //EMAIL
            $table->boolean('email_new_mark')->defailt(false);
            $table->boolean('email_new_chat_message')->defailt(false);
            $table->boolean('email_new_activity')->defailt(false);
            $table->boolean('email_new_test')->defailt(false);
            $table->boolean('email_update_schedule')->defailt(false);
            $table->boolean('email_update_activity')->defailt(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_setting_notifications');
    }
}
