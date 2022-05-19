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
            $table->string('nombre_completo');
            $table->string('cedula');
            $table->string('pasaporte');
            $table->string('ruc');
            $table->string('estado_civil');
            $table->string('separacion_bienes');
            $table->string('carga_familiar');
            $table->string('cyg_nombre_completo');
            $table->string('cyg_cedula');
            $table->string('provincia');
            $table->string('ciudad');
            $table->string('calle_principal');
            $table->string('calle_secundaria');
            $table->string('num_casa');
            $table->string('sector');
            $table->string('telefono');
            $table->string('celular');
            $table->string('correo');
            $table->string('casa_tipo');
            $table->string('tiempo_residencia');
            $table->string('sueldo_ventas');
            $table->string('otros_ingresos');
            $table->string('ingreso_total');
            $table->string('cyg_sueldo');
            $table->string('ingreso_familiar');
            $table->string('descripcion_otros_ingresos');
            $table->string('alimentacion');
            $table->string('arriendo_vivienda');
            $table->string('entidades_bancarias');
            $table->string('otros_gastos');
            $table->string('gastos_total');
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();

            $table->foreign('empresa_id')
                    ->references('id')
                    ->on('bb_solicitud_cliente_empresa')
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
