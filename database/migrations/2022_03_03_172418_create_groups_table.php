<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_admin_id')->nullable();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('group_image')->nullable();
            $table->string('group_color')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('group_admin_id')->references('id')->on('users');
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
