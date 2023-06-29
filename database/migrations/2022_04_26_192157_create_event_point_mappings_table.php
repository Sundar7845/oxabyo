<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPointMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_point_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reward_type_id')->nullable();
            $table->foreign('reward_type_id')->references('id')->on('reward_types');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('point_categories');
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->string('points')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('event_point_mappings');
    }
}
