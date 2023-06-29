<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')->on('events');
            $table->unsignedBigInteger('event_phase_id')->nullable();
            $table->foreign('event_phase_id')->references('id')->on('event_phases');
            $table->unsignedBigInteger('challenger1_id')->nullable();
            $table->foreign('challenger1_id')->references('id')->on('event_player_details');
            $table->unsignedBigInteger('challenger2_id')->nullable();
            $table->foreign('challenger2_id')->references('id')->on('event_player_details'); 
            $table->string('date')->nullable();
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
        Schema::dropIfExists('fixtures');
    }
}
