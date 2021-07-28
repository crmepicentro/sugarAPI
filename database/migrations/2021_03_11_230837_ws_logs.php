<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WsLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ws_logs', function (Blueprint $table) {
            $table->id();
            $table->text('route');
            $table->text('datos_sugar_crm');
            $table->text('datos_adicionales')->nullable();
            $table->text('response')->nullable();
            $table->string('ticket_id')->nullable();
            $table->string('interaccion_id')->nullable();
            $table->rememberToken();
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
        //
    }
}
