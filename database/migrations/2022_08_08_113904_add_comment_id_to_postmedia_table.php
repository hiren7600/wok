<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentIdToPostmediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postmedia', function (Blueprint $table) {
            $table->integer('comment_id')->nullable()->unsigned()->comment('ref table: comments')->after('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postmedia', function (Blueprint $table) {
            $table->dropColumn('comment_id');
        });
    }
}
