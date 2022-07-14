<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuotaAlcancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuota_alcance', function (Blueprint $table) {
            $table->id();
            $table->string('vehiculo')->nullable();
            $table->double('valor')->nullable();
            $table->double('valor_accesorios')->nullable();
            $table->double('valor_seguro')->nullable();
            $table->double('seguro_financiado')->nullable();
            $table->integer('seguro_meses')->nullable();
            $table->double('descuento')->nullable();
            $table->double('otros_cargos')->nullable();
            $table->double('neto')->nullable();
            $table->double('iva')->nullable();
            $table->double('total')->nullable();
            $table->double('financiamiento')->nullable();
            $table->double('entrada')->nullable();
            $table->integer('porcentaje')->nullable();
            $table->double('cuaota_alcance')->nullable();
            $table->date('fecha_alcance')->nullable();
            $table->double('saldo_financiar')->nullable();
            $table->double('intereses')->nullable();
            $table->double('saldo_financiado')->nullable();
            $table->integer('num_cuotas')->nullable();
            $table->double('cuota')->nullable();
            $table->string('tipo_pago')->nullable();
            $table->boolean('tarjeta_credito')->nullable();
            $table->string('tc_tarjeta')->nullable();
            $table->double('tc_valor_tarjeta')->nullable();
            $table->boolean('financiera')->nullable();
            $table->string('f_banco')->nullable();
            $table->double('f_saldo_financiar')->nullable();
            $table->string('f_tiempo_financiar')->nullable();
            $table->boolean('poliza')->nullable();
            $table->string('poliza_banco')->nullable();
            $table->date('poliza_fecha_vencimiento')->nullable();
            $table->double('poliza_valor')->nullable();
            $table->boolean('toma_vehiculo')->nullable();
            $table->double('tv_avaluo')->nullable();
            $table->string('tv_modelo')->nullable();
            $table->double('tv_valor')->nullable();
            $table->string('tv_b_trade_in')->nullable();
            $table->string('tv_b_coach')->nullable();
            $table->boolean('venta_vehiculo')->nullable();
            $table->string('v_vehiculo_marca')->nullable();
            $table->string('v_vehiculo_modelo')->nullable();
            $table->integer('v_vehiculo_anio')->nullable();
            $table->double('v_vehiculo_valor')->nullable();
            $table->boolean('orden_compra')->nullable();
            $table->string('oc_orden')->nullable();
            $table->double('oc_valor')->nullable();
            $table->string('oc_empresa')->nullable();
            $table->boolean('otros')->nullable();
            $table->string('otros_formas')->nullable();
            $table->double('otros_valor')->nullable();
            $table->string('ib_tipo_cuenta_1')->nullable();
            $table->string('ib_no_cuenta_1')->nullable();
            $table->string('ib_banco_1')->nullable();
            $table->integer('ib_anios_1')->nullable();
            $table->string('ib_tipo_cuenta_2')->nullable();
            $table->string('ib_no_cuenta_2')->nullable();
            $table->string('ib_banco_2')->nullable();
            $table->integer('ib_anios_2')->nullable();
            $table->string('rc_empresa_1')->nullable();
            $table->integer('rc_tiempo_relacion_1')->nullable();
            $table->double('rc_monto_compra_1')->nullable();
            $table->string('rc_tipo_empresa_1')->nullable();
            $table->string('rc_empresa_2')->nullable();
            $table->integer('rc_tiempo_relacion_2')->nullable();
            $table->double('rc_monto_compra_2')->nullable();
            $table->string('rc_tipo_empresa_2')->nullable();
            $table->string('rc_descripcion_ubicacion_1')->nullable();
            $table->double('rc_valor_comercial_1')->nullable();
            $table->double('rc_valor_deuda_1')->nullable();
            $table->string('rc_descripcion_ubicacion_2')->nullable();
            $table->double('rc_valor_comercial_2')->nullable();
            $table->double('rc_valor_deuda_2')->nullable();
            $table->string('rc_descripcion_ubicacion_3')->nullable();
            $table->double('rc_valor_comercial_3')->nullable();
            $table->double('rc_valor_deuda_3')->nullable();
            $table->string('rc_descripcion_ubicacion_4')->nullable();
            $table->double('rc_valor_comercial_4')->nullable();
            $table->double('rc_valor_deuda_4')->nullable();
            $table->double('rc_total_bienes_4')->nullable();
            $table->string('rp_nombres_1')->nullable();
            $table->string('rp_apellidos_1')->nullable();
            $table->string('rp_provincia_1')->nullable();
            $table->string('rp_telefono_1')->nullable();
            $table->string('rp_celular_1')->nullable();
            $table->string('rp_nombres_2')->nullable();
            $table->string('rp_apellidos_2')->nullable();
            $table->string('rp_provincia_2')->nullable();
            $table->string('rp_telefono_2')->nullable();
            $table->string('rp_celular_2')->nullable();
            $table->string('rf_nombres_1')->nullable();
            $table->string('rf_apellidos_1')->nullable();
            $table->string('rf_parentezco_1')->nullable();
            $table->string('rf_provincia_1')->nullable();
            $table->string('rf_telefono_1')->nullable();
            $table->string('rf_celular_1')->nullable();
            $table->string('rf_nombres_2')->nullable();
            $table->string('rf_apellidos_2')->nullable();
            $table->string('rf_parentezco_2')->nullable();
            $table->string('rf_provincia_2')->nullable();
            $table->string('rf_telefono_2')->nullable();
            $table->string('rf_celular_2')->nullable();
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
        Schema::dropIfExists('cuota_alcance');
    }
}
