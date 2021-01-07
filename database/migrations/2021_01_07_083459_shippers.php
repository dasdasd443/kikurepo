<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Shippers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('shippers', function(Blueprint $table) {
            $table->id('shipper_id');
            $table->string('shipper_name');
            $table->float('large_cargo_rate');
            $table->float('medium_cargo_rate');
            $table->float('small_cargo_rate');
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
        //
    }
}
