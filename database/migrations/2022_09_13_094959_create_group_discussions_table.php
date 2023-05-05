<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_discussions', function (Blueprint $table) {
            $table->increments('group_discussion_id');
            $table->integer('group_id')->nullable()->unsigned()->comment('ref table: groups');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
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
        Schema::dropIfExists('group_discussions');
    }
}
