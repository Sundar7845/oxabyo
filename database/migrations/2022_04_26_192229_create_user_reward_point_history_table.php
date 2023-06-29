<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRewardPointHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reward_point_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('user_reward_point_history');
            $table->unsignedBigInteger('reward_type_id')->nullable();
            $table->foreign('reward_type_id')->references('id')->on('reward_types');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')->on('events');
            $table->unsignedBigInteger('event_point_mapping_id')->nullable();
            $table->foreign('event_point_mapping_id')->references('id')->on('event_point_mappings');
            $table->unsignedBigInteger('event_phase_id')->nullable();
            $table->foreign('event_phase_id')->references('id')->on('event_phases');
            $table->unsignedBigInteger('fixture_id')->nullable();
            $table->foreign('fixture_id')->references('id')->on('fixtures');            
            $table->integer('points')->nullable();
            $table->boolean('is_active')->default(1);
            $table->enum('status', ['active', 'expired', 'reset'])->nullable();
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
        Schema::dropIfExists('user_reward_point_history');
    }
}
