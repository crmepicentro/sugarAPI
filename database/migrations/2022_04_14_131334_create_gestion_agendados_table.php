<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  CreateGestionAgendadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_gestion_agendados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->uuid('codigo_seguimiento')->notNullable();
            $table->string('codigo_seguimiento_resp_s3s')->nullable();
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
        Schema::dropIfExists('pvt_gestion_agendados');
    }
}
