<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbSolicitudClienteEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bb_solicitud_cliente_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('situacion_laboral');
            $table->string('actividad');
            $table->string('cargo');
            $table->string('direccion');
            $table->string('tiempo_trabajo');
            $table->string('ext_telefono');
            $table->string('cyg_nombre');
            $table->string('cyg_situacion_laboral');
            $table->string('cyg_actividad');
            $table->string('cyg_cargo');
            $table->string('cyg_direccion');
            $table->string('cyg_tiempo_trabajo');
            $table->string('cyg_telefono');
            $table->string('cyg_ext_telefono');
            $table->string('razon_social');
            $table->string('actividad_economica');
            $table->string('ruc');
            $table->integer('cosntitucion_anios');
            $table->integer('cosntitucion_meses');
            $table->string('provincia');
            $table->string('ciudad');
            $table->string('calle_principal');
            $table->string('calle_secundaria');
            $table->string('num_casa');
            $table->string('sector');
            $table->string('telefono');
            $table->string('celular');
            $table->string('correo');
            $table->string('instalaciones');
            $table->integer('sucursales');
            $table->double('total_pasivos');
            $table->double('total_activos');
            $table->double('total_patrimonio');
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
        Schema::dropIfExists('bb_solicitud_cliente_empresa');
    }
}
