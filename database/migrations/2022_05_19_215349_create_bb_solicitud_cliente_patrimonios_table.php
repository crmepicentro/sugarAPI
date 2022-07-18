<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbSolicitudClientePatrimoniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bb_solicitud_cliente_patrimonios', function (Blueprint $table) {
            $table->id();
            $table->string('bien_inmueble')->nullable();
            $table->string('ciudad_direccion')->nullable();
            $table->string('hipotecado')->nullable();
            $table->string('marca_vehiculo')->nullable();
            $table->string('modelo_vehiculo')->nullable();
            $table->integer('anio')->nullable();
            $table->string('prendado')->nullable();
            $table->double('valor_comercial')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->char('patrimonio_tipo')->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')
                    ->references('id')
                    ->on('bb_solicitud_cliente')
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
        Schema::dropIfExists('bb_solicitud_cliente_patrimonios');
    }
}
