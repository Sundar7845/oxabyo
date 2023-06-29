<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixtureResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fixture_id')->nullable();
            $table->foreign('fixture_id')->references('id')->on('fixtures');
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->foreign('winner_id')->references('id')->on('event_player_details');
            $table->unsignedBigInteger('runner_id')->nullable();
            $table->string('number_of_rounds_played')->nullable();            
            $table->foreign('runner_id')->references('id')->on('event_player_details');
            $table->enum('status', ['win', 'no-winner'])->nullable();
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
        Schema::dropIfExists('fixture_results');
    }
}
