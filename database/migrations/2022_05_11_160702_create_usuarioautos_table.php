<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioautosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_usuarioautos', function (Blueprint $table) {
            $table->id();

            $table->string('nomUsuarioVista');
            $table->string('fonoCelUsuarioVisita');
            $table->string('mailUsuarioVisita');

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
        Schema::dropIfExists('pvt_usuarioautos');
    }
}
