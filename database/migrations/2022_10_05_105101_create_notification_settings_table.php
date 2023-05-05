<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->increments('notification_setting_id');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->tinyInteger('inbox_message')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('friend_request')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('follow_me')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('like_image')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('like_video')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('like_topic')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('like_comment')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('mention_member')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('comment_image')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('comment_video')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('comment_topic')->default(0)->comment('0: inactive, 1: active');
            $table->tinyInteger('replay_comment')->default(0)->comment('0: inactive, 1: active');
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
        Schema::dropIfExists('notification_settings');
    }
}
