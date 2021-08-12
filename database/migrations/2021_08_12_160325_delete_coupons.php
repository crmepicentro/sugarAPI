<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('coupons');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->text('invoice');
            $table->text('status_coupon');
            $table->text('status_email');
            $table->text('agencie_id');
            $table->date('date_assign');
            $table->date('date_swap');
            $table->timestamps();
        });
    }
}
