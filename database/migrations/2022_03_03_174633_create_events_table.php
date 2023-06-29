<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->nullable();
            $table->unsignedBigInteger('player_type_id')->nullable();
            $table->unsignedBigInteger('event_type_id')->nullable();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('rules')->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->string('prize_money')->nullable();
            $table->string('match_date')->nullable();
            $table->string('match_hour')->nullable();
            $table->string('oxarate_min')->nullable();
            $table->string('performance_rating_min')->nullable();
            $table->string('ynfluence_rating_min')->nullable();
            $table->string('monetization_rating_min')->nullable();
            $table->string('ticket')->nullable();
            $table->tinyInteger('allow_players_streaming')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('player_id')->references('id')->on('users');
            $table->foreign('event_type_id')->references('id')->on('event_types');
            $table->foreign('player_type_id')->references('id')->on('player_types');
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
