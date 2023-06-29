<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_friends', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('friend_id')->nullable();
            $table->tinyInteger('is_blocked')->default(0);
            $table->tinyInteger('is_connected')->default(0);
            $table->tinyInteger('is_like')->default(0);
            $table->tinyInteger('is_abuse')->default(0);
            $table->string('token')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('friend_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_friends');
    }
}
