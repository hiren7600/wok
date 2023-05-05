<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPostMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_post_media', function (Blueprint $table) {
            $table->increments('ad_post_media_id');
            $table->integer('ad_post_id')->nullable()->unsigned()->comment('ref table: ad_posts');
            $table->string('thumbfile')->nullable();
            $table->string('imagefile')->nullable();
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
        Schema::dropIfExists('ad_post_media');
    }
}
