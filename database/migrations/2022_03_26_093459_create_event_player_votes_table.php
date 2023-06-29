<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPlayerVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_player_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('event_player_id')->nullable();
            $table->foreign('event_player_id')->references('id')->on('event_player_details');
            $table->unsignedBigInteger('performance')->nullable();
            $table->foreign('performance')->references('id')->on('votes');
            $table->unsignedBigInteger('ynfluence')->nullable();
            $table->foreign('ynfluence')->references('id')->on('votes');
            $table->unsignedBigInteger('monetization')->nullable();
            $table->foreign('monetization')->references('id')->on('votes');
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
        Schema::dropIfExists('event_player_votes');
    }
}
