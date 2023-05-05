<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_requests', function (Blueprint $table) {
            $table->increments('group_request_id');
            $table->integer('group_id')->nullable()->unsigned()->comment('ref table: groups');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->tinyInteger('status')->default(0)->comment('0: pending, 1: accepted');
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
        Schema::dropIfExists('group_requests');
    }
}
