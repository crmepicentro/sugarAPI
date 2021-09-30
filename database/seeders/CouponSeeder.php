<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Campaigns::factory()->create(['name'=>'Seguros','company_id'=>1,'type' => 'CUPON-INCON','id_sugar_campaign'=> null,'name_sugar_campaign'=>null]);
    }
}
