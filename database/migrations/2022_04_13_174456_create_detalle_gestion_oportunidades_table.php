<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleGestionOportunidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_detalle_gestion_oportunidades', function (Blueprint $table) {
            $table->id();
            $table->string('ws_log_id');

            $table->unsignedBigInteger('auto_id');
            $table->foreign('auto_id')->references('id')->on('pvt_autos');

            $table->string('oportunidad_id')->unique()->comment('id de la oportunidad que debe venir del S3S, se entiende que es unico por cada factura se entiende que es el id que diferencia de las demas oportunidades de otras facturas, en caso de ser repetidas debe relacionarse con la factura para diferenciar las oportunidades dentro de otras facturas')->nullable();


            $table->string('codAgencia');
            $table->string('nomAgencia');
            $table->string('ordTaller');
            $table->double('kmVehiculo');
            $table->double('kmRelVehiculo');
            $table->string('ordFechaCita');
            $table->string('ordFechaCrea');
            $table->string('ordFchaCierre');
            $table->string('codOrdAsesor');
            $table->string('nomOrdAsesor');

            $table->string('codServ');
            $table->string('descServ');
            $table->double('cantidad');
            $table->string('cargosCobrar');
            $table->string('tipoCL');
            $table->string('facturado');


            $table->string('tipoServ');
            $table->string('franquicia');


            $table->dateTime('cita_fecha')->nullable();
            $table->string('s3s_codigo_seguimiento')->nullable();

            $table->dateTime('facturacion_fecha')->nullable();
            $table->string('facturacion_agente')->nullable();

            $table->dateTime('perdida_fecha')->nullable();
            $table->string('perdida_agente')->nullable();
            $table->string('perdida_motivo')->nullable();

            $table->dateTime('ganado_fecha')->nullable();
            $table->string('ganado_factura')->nullable();

            $table->dateTime('agendado_fecha')->nullable();

            $table->dateTime('gestion_fecha')->nullable();
            $table->enum('gestion_tipo',['nuevo','cita','recordatorio','perdido']);

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
        Schema::dropIfExists('pvt_detalle_gestion_oportunidades');
    }
}
