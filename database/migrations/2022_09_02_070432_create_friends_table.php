<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->increments('friend_id');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->integer('to_user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: pending, 1: aproved, 2: decline');
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
        Schema::dropIfExists('friends');
    }
}
