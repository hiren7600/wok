<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_media', function (Blueprint $table) {
            $table->increments('media_id');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->tinyInteger('mediatype')->default(1)->comment('1: image, 2: video');
            $table->string('caption')->nullable();
            $table->string('tag')->nullable();
            $table->string('mediafile')->nullable();
            $table->string('thumbfile')->nullable();
            $table->tinyInteger('showto')->default(0)->comment('0: everyone, 1: friends only');
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
        Schema::dropIfExists('user_media');
    }
}
