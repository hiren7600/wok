<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKinkMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kink_members', function (Blueprint $table) {
            $table->increments('kink_member_id');
            $table->integer('tag_id')->nullable()->unsigned()->comment('ref table: tags');
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
        Schema::dropIfExists('kink_members');
    }
}
