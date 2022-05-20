<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbSolicitudClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bb_solicitud_cliente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo')->nullable();
            $table->string('cedula')->nullable();
            $table->string('pasaporte')->nullable();
            $table->string('ruc')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('separacion_bienes')->nullable();
            $table->string('carga_familiar')->nullable();
            $table->string('cyg_nombre_completo')->nullable();
            $table->string('cyg_cedula')->nullable();
            $table->string('provincia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('calle_principal')->nullable();
            $table->string('calle_secundaria')->nullable();
            $table->string('no_casa')->nullable();
            $table->string('sector')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('correo')->nullable();
            $table->string('casa_tipo')->nullable();
            $table->integer('tiempo_residencia')->nullable();
            $table->double('sueldo_ventas')->nullable();
            $table->double('otros_ingresos')->nullable();
            $table->double('ingreso_total')->nullable();
            $table->double('cyg_sueldo')->nullable();
            $table->double('ingreso_familiar')->nullable();
            $table->string('descripcion_otros_ingresos')->nullable();
            $table->double('alimentacion')->nullable();
            $table->double('arriendo_vivienda')->nullable();
            $table->double('entidades_bancarias')->nullable();
            $table->double('otros_gastos')->nullable();
            $table->double('gastos_total')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('referencias_id')->nullable();
            $table->timestamps();

            $table->foreign('empresa_id')
                    ->references('id')
                    ->on('bb_solicitud_cliente_empresa')
                    ->onDelete('cascade');

            $table->foreign('referencias_id')
                    ->references('id')
                    ->on('bb_solicitud_cliente_referencias')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bb_solicitud_cliente');
    }
}
