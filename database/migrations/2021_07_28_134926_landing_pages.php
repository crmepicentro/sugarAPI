<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LandingPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->text('name', 100)->nullable();
            $table->integer('medio')->nullable();
            $table->text('campaign', 100)->nullable();
            $table->json('properties_form')->nullable();
            $table->text('user_login', 20)->nullable();
            $table->text('business_line_id', 100)->nullable();
            $table->integer('type_transaction')->nullable();
            $table->text('user_assigned_position')->nullable();
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
        Schema::dropIfExists('landing_pages');
    }
}
