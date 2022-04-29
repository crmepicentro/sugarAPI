<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductorAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_conductor_autos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('conductor_id');
            $table->foreign('conductor_id')->references('id')->on('pvt_conductors');

            $table->unsignedBigInteger('auto_id');
            $table->foreign('auto_id')->references('id')->on('pvt_autos');

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
        Schema::dropIfExists('pvt_conductor_autos');
    }
}
