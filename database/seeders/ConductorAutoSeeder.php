<?php

namespace Database\Seeders;

use App\Models\Auto;
use App\Models\Conductor;
use App\Models\ConductorAuto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ConductorAutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ( Auto::all() as $auto ) {
            $quienllevaauto =[
                0 ,
                0 ,
                0 ,
                1 ,
                3 ,
                4 ,
            ];
            $randomData = Arr::random($quienllevaauto);
            for( $i = 0; $i < $randomData; $i++ ) {
                $conductor = Conductor::inRandomOrder()->first();
                ConductorAuto::create([
                    'conductor_id' => $conductor->id,
                    'auto_id' => $auto->id,
                ]);
            }

        }
    }
}
