<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_posts', function (Blueprint $table) {
            $table->increments('ad_post_id');
            $table->integer('ad_category_id')->nullable()->unsigned()->comment('ref table: ad_categories');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->string('title')->nullable();
            $table->text('location')->nullable();
            $table->text('content')->nullable();
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
        Schema::dropIfExists('ad_posts');
    }
}
