<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_autos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propietario_id');
            $table->foreign('propietario_id')->references('id')->on('pvt_propietarios');
            $table->string("id_ws_logs");
            $table->string('id_auto_s3s')->unique()->nullable();
            $table->string('chasis')->unique()->nullable();
            $table->string('placa');
            $table->string('modelo');
            $table->longText('descVehiculo');
            $table->string('marcaVehiculo');
            $table->string('anioVehiculo');
            $table->string('masterLocVehiculo');
            $table->string('katashikiVehiculo');


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
        Schema::dropIfExists('pvt_autos');
    }
}
