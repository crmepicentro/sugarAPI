<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionAgendadoDetalleOportunidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_gestion_agendado_detalle_op', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('detalle_gestion_oportunidad_id');
            $table->foreign('detalle_gestion_oportunidad_id','fk_detallegestion')->references('id')->on('pvt_detalle_gestion_oportunidades');
            $table->unsignedBigInteger('gestion_agendado_id');
            $table->foreign('gestion_agendado_id','fk_gestion_agendados')->references('id')->on('pvt_gestion_agendados');

            $table->enum('tipo_gestion',['cita','recordatorio','perdido','perdido_taller','cita_ok','cita_noshow','borrar_cita']);
            $table->integer('activo')->default(\App\Models\GestionAgendadoDetalleOportunidades::$ESTADO_ACTIVO);

            $table->integer('estado_s3s')->default(\App\Models\GestionAgendadoDetalleOportunidades::$ESTADO_INICIAL_S3S);

            $table->dateTime('fecha_agendamiento')->nullable();
            $table->text('asunto_agendamiento')->nullable();
            $table->longText('observacion_agendamiento')->nullable();

            $table->text('agencia_cita')->nullable();
            $table->longText('observacion_cita')->nullable();

            $table->text('motivo_perdida');

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
        Schema::dropIfExists('pvt_gestion_agendado_detalle_op');
    }
}
