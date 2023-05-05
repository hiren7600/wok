<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMediumthumbfileLargethumbfileColumnAndRenameThumbfileColumnToSmallthumbfileUserMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_media', function (Blueprint $table) {
            $table->string('mediumthumbfile')->nullable()->after('thumbfile');
            $table->string('largethumbfile')->nullable()->after('mediumthumbfile');
            $table->renameColumn('thumbfile', 'smallthumbfile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_media', function (Blueprint $table) {
            $table->dropColumn('mediumthumbfile');
            $table->dropColumn('largethumbfile');
            $table->renameColumn('smallthumbfile', 'thumbfile');
        });
    }
}
