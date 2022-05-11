<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_facturas', function (Blueprint $table) {
            $table->id();

            $table->string('codCliFactura')->unique();
            $table->string('ciCliFactura');
            $table->string('nomCliFactura');
            $table->string('mail1CliFactura');
            $table->string('mali2CliFactura');
            $table->string('fonoCliDomFactura');
            $table->string('fonoCliTrabFactura');
            $table->string('fonoCliCelFactura');

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
        Schema::dropIfExists('pvt_facturas');
    }
}
