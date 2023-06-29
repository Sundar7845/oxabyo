<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_invites', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')->on('events');

            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');

            $table->unsignedBigInteger('invitee_id')->nullable();
            $table->foreign('invitee_id')->references('id')->on('users');
            $table->unsignedBigInteger('invite_sent_by')->nullable();
            $table->foreign('invite_sent_by')->references('id')->on('users');
            $table->tinyInteger('is_invite_accept')->default(0);
            $table->tinyInteger('is_champion')->default(0);
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
        Schema::dropIfExists('event_invites');
    }
}
