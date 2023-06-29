<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamJoineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_joinees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('joinee_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('request_sent_date')->nullable();
            $table->string('request_approved_date')->nullable();
            $table->string('token')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('joinee_id')->references('id')->on('users');
            $table->foreign('approved_by_id')->references('id')->on('users');
            $table->foreign('team_id')->references('id')->on('teams');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_joinees');
    }
}
