<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitch', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('twitch_user_id')->nullable();
            $table->string('twitch_login')->nullable();
            $table->string('twitch_display_name')->nullable();
            $table->string('channel_name')->nullable();
            $table->string('type')->nullable();
            $table->string('online_status')->nullable();
            $table->string('broadcaster_type')->nullable();
            $table->string('description')->nullable();
            $table->string('last_streaming')->nullable();
            $table->string('followers')->nullable();
            $table->string('subscribers')->nullable();
            $table->string('last_cover')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('twitch');
    }
}
