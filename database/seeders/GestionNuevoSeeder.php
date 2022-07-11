<?php

namespace Database\Seeders;

use App\Models\Gestion\GestionCita;
use App\Models\Postventas\DetalleGestionOportunidades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class GestionCitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (DetalleGestionOportunidades::all() as $detalle) {
            $factor = [
                0,0,1,2,1,2,3,1,0,0,1,0,0,1,2,0,0,0,5
            ];
            $elige = Arr::random($factor);
            if($elige > 0) {
                GestionCita::factory($elige)->create([
                    'detalle_gestion_oportunidad_id' => $detalle->id,
                ]);
            }
        }
    }
}
