<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampaignsContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Relación Varios a Varios con lógica de Strapi campaigns_contacts_ids__contacts_campaigns_ids (campaigns - contacts)
        Schema::create('campaigns_contacts_ids__contacts_campaigns_ids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns_contacts_ids__contacts_campaigns_ids');
    }
}
