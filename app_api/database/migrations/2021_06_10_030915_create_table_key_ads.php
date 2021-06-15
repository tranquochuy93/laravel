<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKeyAds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_ads', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('banner_id');
            $table->string('native_id');
            $table->string('full_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('key_ads', function (Blueprint $table) {
            //
        });
    }
}
