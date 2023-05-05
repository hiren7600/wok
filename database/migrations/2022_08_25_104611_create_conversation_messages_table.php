<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_messages', function (Blueprint $table) {
            $table->increments('conversation_message_id');
            $table->integer('conversation_id')->nullable()->unsigned()->comment('ref table: users');
            $table->text('message')->nullable();
            $table->string('imagefile')->nullable();
            $table->string('thumbfile')->nullable();
            $table->tinyInteger('is_read')->default(0)->comment('0: unread, 1: read');
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
        Schema::dropIfExists('conversation_messages');
    }
}
