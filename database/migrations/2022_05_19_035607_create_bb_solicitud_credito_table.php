<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbSolicitudCreditoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bb_solicitud_credito', function (Blueprint $table) {
            $table->id();
            $table->string('id_cotizacion')->nullable();
            $table->string('producto')->nullable();
            $table->double('valor_producto')->nullable();
            $table->double('entrada')->nullable();
            $table->double('valor_financiar')->nullable();
            $table->integer('plazo')->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->string('asesor')->nullable();
            $table->string('agencia')->nullable();
            $table->string('cedula_cliente')->nullable();
            $table->string('id_cb')->nullable();
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
        Schema::dropIfExists('bb_solicitud_credito');
    }
}
