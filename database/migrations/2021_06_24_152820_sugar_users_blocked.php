<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SugarUsersBlocked extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sugar_users_blocked', function (Blueprint $table) {
            $table->id();
            $table->string('sugar_user_id',100)->nullable();
            $table->date('date_unblocked')->nullable();
            $table->string('user_creation', 100)->nullable();
            $table->string('user_modified', 100)->nullable();
            $table->text('sources_blocked')->nullable();
            $table->string('sugar_user_agency', 100)->nullable();
            $table->string('status', 10)->default('active');
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
        Schema::dropIfExists('sugar_users_blocked');
    }
}
