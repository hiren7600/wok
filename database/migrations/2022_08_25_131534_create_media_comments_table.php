<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_comments', function (Blueprint $table) {
            $table->increments('media_comment_id');
            $table->integer('media_id')->nullable()->unsigned()->comment('ref table: user_media');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->integer('parent_id')->nullable()->comment('ref table: media_comments(it self)');
            $table->string('comment')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0: image, 1: video');
            $table->tinyInteger('isread')->default(0)->comment('0: unread, 1: read');
            $table->tinyInteger('status')->default(1)->comment('0: inactive, 1: active');
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
        Schema::dropIfExists('media_comments');
    }
}
