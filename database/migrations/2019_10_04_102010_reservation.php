<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('reservation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('flightnumber');
            $table->mediumText('seat_number');
            $table->mediumText('date');
            $table->mediumText('passanger_name');

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
