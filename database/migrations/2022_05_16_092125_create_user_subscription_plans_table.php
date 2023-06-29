<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscription_plans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('pricing_plan_id')->nullable();
            $table->integer('number_of_plans')->nullable();
            $table->tinyInteger('is_month')->nullable();
            $table->tinyInteger('is_year')->nullable();
            $table->integer('invoice_amount')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('date_subscribed')->nullable();
            $table->dateTime('date_unsubscribed')->nullable();
            $table->dateTime('date_paid')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('plan_status')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pricing_plan_id')->references('id')->on('pricing_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_subscription_plans');
    }
}
