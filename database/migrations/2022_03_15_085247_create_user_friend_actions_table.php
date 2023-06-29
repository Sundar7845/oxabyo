<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFriendActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_friend_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_friend_id')->nullable();
            $table->unsignedBigInteger('user_action_id')->nullable();
            $table->string('date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->foreign('user_friend_id')->references('id')->on('user_friends');
            $table->foreign('user_action_id')->references('id')->on('user_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_friend_actions');
    }
}
