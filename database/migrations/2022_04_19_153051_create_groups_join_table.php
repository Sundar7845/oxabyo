<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_join', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('join_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('request_sent_date')->nullable();
            $table->string('request_approved_date')->nullable();
            $table->string('token')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('join_id')->references('id')->on('users');
            $table->foreign('approved_by_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups_join');
    }
}