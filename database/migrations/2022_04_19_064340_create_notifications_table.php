<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sender_user_id')->nullable();
            $table->foreign('sender_user_id')->references('id')->on('users');

            $table->unsignedBigInteger('receiver_user_id')->nullable();
            $table->foreign('receiver_user_id')->references('id')->on('users');

            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->longText('accept_href')->nullable();
            $table->longText('decline_href')->nullable();
            $table->boolean('is_read')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
