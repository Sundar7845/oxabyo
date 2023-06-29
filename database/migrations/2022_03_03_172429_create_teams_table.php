<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->unsignedBigInteger('admin_user_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('team_image')->nullable();
            $table->string('team_color')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('admin_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
