<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvt_conductors', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 10)->unique();
            $table->string('contact_id', 50)->unique();
            $table->string('nombre_usuario', 100);
            $table->string('apellido_usuario', 100);
            $table->string('telefono_usuario', 50);
            $table->string('email_usuario', 150);
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
        Schema::dropIfExists('pvt_conductors');
    }
}
