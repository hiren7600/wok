<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDiscussionReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_discussion_reads', function (Blueprint $table) {
            $table->increments('group_discussion_read_id');
            $table->integer('group_id')->nullable()->unsigned()->comment('ref table: groups');
            $table->integer('group_discussion_id')->nullable()->unsigned()->comment('ref table: group_discussions');
            $table->integer('user_id')->nullable()->unsigned()->comment('ref table: users');
            $table->tinyInteger('is_read')->default(0)->comment('0: no, 1: yes');
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
        Schema::dropIfExists('group_discussion_reads');
    }
}
