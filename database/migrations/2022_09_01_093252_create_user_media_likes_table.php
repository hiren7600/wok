<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMediaLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_media_likes', function (Blueprint $table) {
            $table->increments('user_media_like_id');
            $table->integer('media_id')->nullable()->unsigned()->comment('ref table: user_medias');
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
        Schema::dropIfExists('user_media_likes');
    }
}
