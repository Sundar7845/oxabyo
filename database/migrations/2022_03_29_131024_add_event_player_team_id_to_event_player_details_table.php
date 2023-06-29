<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventPlayerTeamIdToEventPlayerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_player_details', function (Blueprint $table) {
            $table->unsignedBigInteger('event_player_team_id')->after('id')->nullable();
            $table->foreign('event_player_team_id')->references('id')->on('event_player_teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_player_details', function (Blueprint $table) {
            $table->dropForeign(['event_player_team_id']);
            $table->dropColumn(['event_player_team_id']);
        });
    }
}
