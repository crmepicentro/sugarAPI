<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaNaturalsTable extends Migration
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
            $table->string('id_cotizacion');
            $table->string('producto');
            $table->double('valor_producto');
            $table->double('entrada');
            $table->double('valor_financiar');
            $table->integer('plazo');
            $table->date('fecha_solicitud');
            $table->string('asesor');
            $table->string('agencia');
            $table->string('cedula_cliente');
            $table->string('id_cb');
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
        Schema::dropIfExists('persona_naturals');
    }
}
