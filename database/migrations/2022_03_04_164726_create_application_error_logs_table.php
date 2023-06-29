<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationErrorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_process_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('login_type',25)->nullable();
            $table->string('description')->nullable();
            $table->string('status_code',25)->nullable();
            $table->string('class_name',50)->nullable();
            $table->string('method_name',50)->nullable();
            $table->integer('line_number')->nullable();
            $table->string('ip_address',255)->nullable();
            $table->text('payload')->nullable();
            $table->text('stack_trace')->nullable();
            $table->boolean('critical')->nullable();
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
        Schema::dropIfExists('application_process_logs');
    }
}
