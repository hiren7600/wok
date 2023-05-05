<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDiscussionCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_discussion_comments', function (Blueprint $table) {
            $table->increments('group_discussion_comment_id');
            $table->integer('group_discussion_id')->nullable()->unsigned()->comment('ref table: group_discussions');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->string('comments')->nullable();
            $table->string('imagefile')->nullable();
            $table->string('thumbimagefile')->nullable();
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
        Schema::dropIfExists('group_discussion_comments');
    }
}
