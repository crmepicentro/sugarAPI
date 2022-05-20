<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbSolicitudClienteReferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bb_solicitud_cliente_referencias', function (Blueprint $table) {
            $table->id();
            $table->string('institucion_1')->nullable();
            $table->string('cuenta_tipo_1')->nullable();
            $table->string('no_cuenta_1')->nullable();
            $table->string('tarjeta_tipo_1')->nullable();
            $table->string('banco_emisor_1')->nullable();
            $table->string('institucion_2')->nullable();
            $table->string('cuenta_tipo_2')->nullable();
            $table->string('no_cuenta_2')->nullable();
            $table->string('tarjeta_tipo_2')->nullable();
            $table->string('banco_emisor_2')->nullable();
            $table->string('nombre_completo_1')->nullable();
            $table->string('relacion_cliente_1')->nullable();
            $table->string('ciudad_1')->nullable();
            $table->string('telefono_1')->nullable();
            $table->string('nombre_completo_2')->nullable();
            $table->string('relacion_cliente_2')->nullable();
            $table->string('ciudad_2')->nullable();
            $table->string('telefono_2')->nullable();
            $table->string('nombre_completo_3')->nullable();
            $table->string('relacion_cliente_3')->nullable();
            $table->string('ciudad_3')->nullable();
            $table->string('telefono_3')->nullable();
            $table->string('empresa_nombre_1')->nullable();
            $table->string('empresa_ciudad_1')->nullable();
            $table->string('empresa_telefono_1')->nullable();
            $table->string('empresa_nombre_2')->nullable();
            $table->string('empresa_ciudad_2')->nullable();
            $table->string('empresa_telefono_2')->nullable();
            $table->string('compra_nombre_completo')->nullable();
            $table->string('compra_correo')->nullable();
            $table->string('compra_celular')->nullable();
            $table->string('compra_telefono')->nullable();
            $table->string('compra_ext_telefono')->nullable();
            $table->string('pago_nombre_completo')->nullable();
            $table->string('pago_correo')->nullable();
            $table->string('pago_celular')->nullable();
            $table->string('pago_telefono')->nullable();
            $table->string('pago_ext_telefono')->nullable();
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
        Schema::dropIfExists('bb_solicitud_cliente_referencias');
    }
}
