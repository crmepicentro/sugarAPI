<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WsInconcertLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ws_inconcert_logs', function (Blueprint $table) {
            $table->id();
            $table->text('route')->nullable();
            $table->text('environment')->nullable();
            $table->text('source')->nullable();
            $table->text('datos_sugar_crm')->nullable();
            $table->text('datos_adicionales')->nullable();
            $table->text('response_inconcert')->nullable();
            $table->string('contact_id')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('ws_inconcert_logs');
    }
}
