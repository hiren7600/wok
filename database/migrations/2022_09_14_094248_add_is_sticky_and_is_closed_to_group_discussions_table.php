<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsStickyAndIsClosedToGroupDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_discussions', function (Blueprint $table) {
            $table->tinyInteger('is_sticky')->default(0)->after('thumbimagefile')->comment = '0: no, 1: yes';
            $table->tinyInteger('is_closed')->default(0)->after('is_sticky')->comment = '0: no, 1: yes';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_discussions', function (Blueprint $table) {
            $table->dropColumn('is_sticky');
            $table->dropColumn('is_closed');
        });
    }
}
