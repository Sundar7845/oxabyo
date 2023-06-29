<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_permissions', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('pricing_plan_id')->nullable();
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->integer('value')->nullable();
            $table->tinyInteger('is_unlimited')->nullable();
            $table->tinyInteger('is_allowed')->nullable();
            $table->foreign('pricing_plan_id')->references('id')->on('pricing_plans');
            $table->foreign('permission_id')->references('id')->on('permissions');
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
        Schema::dropIfExists('subscription_permissions');
    }
}
