<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPlayerActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_player_actions', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('event_player_id')->nullable();
            $table->foreign('event_player_id')->references('id')->on('event_player_details');
            $table->unsignedBigInteger('event_action_id')->nullable();
            $table->foreign('event_action_id')->references('id')->on('event_actions');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('event_player_actions');
    }
}
