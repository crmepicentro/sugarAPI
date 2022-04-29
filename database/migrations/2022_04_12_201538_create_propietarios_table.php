<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropietariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_propietarios', function (Blueprint $table) {
            $table->id();
            $table->string('contact_id', 50)->unique()->nullable();
            $table->unsignedBigInteger('codPropietario')->unique();
            $table->string("id_ws_logs");
            $table->string('cedula', 20);
            $table->string('nombre_propietario', 100);
            $table->string('email_propietario', 150);
            $table->string('email_propietario_2', 150);

            $table->string('telefono_domicilio', 50);
            $table->string('telefono_trabajo', 50);
            $table->string('telefono_celular', 50);

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
        Schema::dropIfExists('pvt_propietarios');
    }
}
