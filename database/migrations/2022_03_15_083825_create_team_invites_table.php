<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_invites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invitee_id')->nullable();
            $table->unsignedBigInteger('invite_sent_by')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->tinyInteger('is_invite_sent')->default(0);
            $table->tinyInteger('is_invite_accept')->default(0);
            $table->string('invite_sent_date')->nullable();
            $table->string('invite_accept_date')->nullable();
            $table->string('invite_reject_date')->nullable();
            $table->string('token')->nullable();
            $table->foreign('invitee_id')->references('id')->on('users');
            $table->foreign('invite_sent_by')->references('id')->on('users');
            $table->foreign('team_id')->references('id')->on('teams');
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
        Schema::dropIfExists('team_invites');
    }
}
