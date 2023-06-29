<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMemberActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_member_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_member_id')->nullable();
            $table->unsignedBigInteger('team_action_id')->nullable();
            $table->string('date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreign('team_member_id')->references('id')->on('team_members');
            $table->foreign('team_action_id')->references('id')->on('team_actions');
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
        Schema::dropIfExists('team_member_actions');
    }
}
