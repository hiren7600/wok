<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostmediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postmedia', function (Blueprint $table) {
            $table->increments('postmedia_id');
            $table->integer('post_id')->nullable()->unsigned()->comment('ref table: posts');
            $table->string('path')->nullable();
            $table->string('extension')->nullable();
            $table->tinyInteger('media_type')->default(0)->comment('0: image, 1: video');
            $table->tinyInteger('type')->default(0)->comment('0: post, 1: comment');
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
        Schema::dropIfExists('postmedia');
    }
}
