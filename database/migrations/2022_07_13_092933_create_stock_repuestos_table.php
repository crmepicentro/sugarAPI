<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_stock_repuestos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id');

            $table->string('franquicia');
            $table->string('bodega',10);
            $table->string('codigoRepuesto')->comment('Es el dato guardado en pvt_detalle_gestion_oportunidades codServ');
            $table->integer('cantExistencia');
            $table->dateTime('available_at')->comment('Es el dato que indica hasta cuando esta este producto habil para compra, es un time to live');
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
        Schema::dropIfExists('pvt_stock_repuestos');
    }
}
