<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Airport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('airport', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('airportcode');
            $table->mediumText('name');
            $table->mediumText('city');
            $table->mediumText('country');
            
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
