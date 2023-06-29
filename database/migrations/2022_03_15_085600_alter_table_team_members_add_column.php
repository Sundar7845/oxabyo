<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTeamMembersAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->unsignedBigInteger('team_joinee_id')->after('user_id')->nullable();
            $table->unsignedBigInteger('team_invite_id')->after('team_joinee_id')->nullable();
            $table->foreign('team_joinee_id')->references('id')->on('team_joinees');
            $table->foreign('team_invite_id')->references('id')->on('team_invites');
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropForeign(['team_joinee_id']);
            $table->dropForeign(['team_invite_id']);
            $table->dropColumn(['team_invite_id', 'team_joinee_id']);
        });
    }
}
