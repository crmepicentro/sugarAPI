<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionNuevosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_gestion_nuevos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detalle_gestion_oportunidad_id');
            $table->foreign('detalle_gestion_oportunidad_id')->references('id')->on('pvt_detalle_gestion_oportunidades');
            $table->unsignedBigInteger('users_id');
            $table->dateTime('fecha_agendamiento');
            $table->longText('observacion_agendamiento');
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
        Schema::dropIfExists('pvt_gestion_nuevos');
    }
}
