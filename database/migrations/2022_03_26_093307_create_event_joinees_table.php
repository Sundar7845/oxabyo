<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventJoineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_joinees', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')->on('events');
            $table->unsignedBigInteger('joinee_id')->nullable();
            $table->foreign('joinee_id')->references('id')->on('users');
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->foreign('approved_by_id')->references('id')->on('users');
            $table->string('token')->nullable();
            $table->enum('status', ['approved', 'rejected', 'sent'])->nullable();
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
        Schema::dropIfExists('event_joinees');
    }
}
