<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->unique();
            $table->foreignId('campaign_id')->constrained();
            $table->foreignId('contact_id')->constrained();
            $table->string('referer',100)->nullable();
            $table->string('id_sugar_agency',50)->nullable();
            $table->string('name_sugar_agency',100)->nullable();
            $table->date('date_assign');
            $table->date('date_swap')->nullable();
            $table->date('date_validity');
            $table->boolean('status')->default(true);
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('coupons');
    }
}
