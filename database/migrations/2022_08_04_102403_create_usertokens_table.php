<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsertokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usertokens', function (Blueprint $table) {
            $table->increments('usertoken_id');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->integer('type')->nullable()->comment('0: registration verification, 1: password reset');
            $table->string('email_username')->nullable();
            $table->text('token')->nullable();
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
        Schema::dropIfExists('usertokens');
    }
}
