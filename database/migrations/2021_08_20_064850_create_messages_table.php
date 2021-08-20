<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('sender_id');
            $table->foreign('sender_id')->references('id')->on('users');

            $table->foreignId('recipient_id');
            $table->foreign('recipient_id')->references('id')->on('users');

            $table->string('conversation_id', 255);
            $table->integer('subject_id');
            $table->text('body');

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
        Schema::dropIfExists('messages');
    }
}
