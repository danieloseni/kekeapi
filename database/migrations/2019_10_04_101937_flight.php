<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Flight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('flight', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('flightnumber');
            $table->mediumText('airline');
            $table->mediumText('from_airport_code');
            $table->mediumText('to_airport_code');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
