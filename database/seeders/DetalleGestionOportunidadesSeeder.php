<?php

namespace Database\Seeders;

use App\Models\Auto;
use App\Models\Conductor;
use App\Models\ConductorAuto;
use App\Models\DetalleGestionOportunidades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DetalleGestionOportunidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ( Auto::all() as $auto ) {
            $oportunida = 'CL-000'. random_int(80, 200);
            $tipo_oportunida = Arr::random(['CL1','CL2']);
            $quienllevaauto =[
                1 ,
                1 ,
                1 ,
                2 ,
                3 ,
                4 ,
                5 ,
            ];
            $randomData = Arr::random($quienllevaauto);
            DetalleGestionOportunidades::factory($randomData)->create( [
                'auto_id' => $auto->id,


            ] );
        }
    }
}
