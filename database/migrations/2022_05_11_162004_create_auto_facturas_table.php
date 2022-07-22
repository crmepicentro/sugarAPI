<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_auto_facturas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('autos_id');
            $table->foreign('autos_id')->references('id')->on('pvt_autos');

            $table->unsignedBigInteger('factura_id');
            $table->foreign('factura_id')->references('id')->on('pvt_facturas');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvt_auto_facturas');
    }
}