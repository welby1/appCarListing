<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->string('body_type', 50);
            $table->string('fuel_type', 50);
            $table->unsignedSmallInteger('engine_displ'); // 0 .. 65 535 (ccm)
            $table->string('transmission_type', 50);
            $table->unsignedMediumInteger('price'); // 0 .. 16 777 215
            $table->text('description');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('cars');
    }
}
