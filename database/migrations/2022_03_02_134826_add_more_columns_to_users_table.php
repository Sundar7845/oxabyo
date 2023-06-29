<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username',50)->after('name')->nullable();       
            $table->string('surename',50)->after('password')->nullable();
            $table->string('dob',25)->after('surename')->nullable();
            $table->string('address')->after('dob')->nullable();
            $table->string('city',100)->after('address')->nullable();
            $table->text('bio_data')->after('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'surename', 'dob', 'address', 'city', 'bio_data']);
        });
    }
}

   



