<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->tinyInteger('usertype')->default(2)->comment('1: admin, 2: user');
            $table->tinyInteger('issuperadmin')->default(0)->comment = '0: not super admin, 1: super admin';
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->date('dob')->nullable();
            $table->string('phoneno')->nullable();
            $table->string('imagefile')->nullable();
            $table->string('gender')->nullable();
            $table->string('sexual_orientation')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('role')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: inactive, 1: active');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
