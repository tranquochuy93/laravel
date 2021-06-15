<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFreeTrial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_trial', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->dateTime('time_free_trial');
            $table->boolean('has_in_app');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free_trial', function (Blueprint $table) {
            //
        });
    }
}
