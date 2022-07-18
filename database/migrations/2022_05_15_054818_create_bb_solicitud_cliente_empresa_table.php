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
            $table->string('nombre')->nullable();
            $table->string('situacion_laboral')->nullable();
            $table->string('actividad')->nullable();
            $table->string('cargo')->nullable();
            $table->string('direccion')->nullable();
            $table->integer('tiempo_trabajo')->nullable();
            $table->string('ext_telefono')->nullable();
            $table->string('cyg_nombre')->nullable();
            $table->string('cyg_situacion_laboral')->nullable();
            $table->string('cyg_actividad')->nullable();
            $table->string('cyg_cargo')->nullable();
            $table->string('cyg_direccion')->nullable();
            $table->integer('cyg_tiempo_trabajo')->nullable();
            $table->string('cyg_telefono')->nullable();
            $table->string('cyg_ext_telefono')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('actividad_economica')->nullable();
            $table->string('ruc')->nullable();
            $table->integer('cosntitucion_anios')->nullable();
            $table->integer('cosntitucion_meses')->nullable();
            $table->string('provincia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('calle_principal')->nullable();
            $table->string('calle_secundaria')->nullable();
            $table->string('no_casa')->nullable();
            $table->string('sector')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('correo')->nullable();
            $table->string('instalaciones')->nullable();
            $table->integer('sucursales')->nullable();
            $table->double('total_pasivos')->nullable();
            $table->double('total_activos')->nullable();
            $table->double('total_patrimonio')->nullable();
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
