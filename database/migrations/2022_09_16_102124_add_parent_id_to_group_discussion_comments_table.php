<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentIdToGroupDiscussionCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_discussion_comments', function (Blueprint $table) {
            $table->integer('parent_id')->after('user_id')->nullable()->unsigned()->comment('ref table: group_discussion_comments(it self)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_discussion_comments', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}
