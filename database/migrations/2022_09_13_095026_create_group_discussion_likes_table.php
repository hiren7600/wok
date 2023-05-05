<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDiscussionLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_discussion_likes', function (Blueprint $table) {
            $table->increments('group_discussion_like_id');
            $table->integer('group_discussion_id')->nullable()->unsigned()->comment('ref table: group_discussions');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
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
        Schema::dropIfExists('group_discussion_likes');
    }
}
