<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMemberAction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_member_action', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_member_id')->nullable();
            $table->unsignedBigInteger('group_action_id')->nullable();
            $table->string('date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreign('group_member_id')->references('id')->on('group_members');
            $table->foreign('group_action_id')->references('id')->on('group_actions');
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
        Schema::dropIfExists('group_member_action');
    }
}